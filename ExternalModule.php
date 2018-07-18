<?php

namespace HideChoiceByEvent\ExternalModule;

use ExternalModules\AbstractExternalModule;
use ExternalModules\ExternalModules;


/**
 * ExternalModule class for Project Ownership module.
 */
class ExternalModule extends AbstractExternalModule {

    /**
     * @inheritdoc
     */
    function hook_every_page_top($project_id) {
        if (PAGE == 'Design/online_designer.php' && $project_id) {
            $this->includeJs('js/modify_help_menu.js');
            return;
        }

        //if not on a data entry page or survey, then don't do anything
        if (!in_array(PAGE, array('DataEntry/index.php', 'surveys/index.php'))) {
            return;
        }

        global $Proj;
        $settings = array();

        //get the name of every field on this page.
        $fields = array_keys($Proj->forms[$_GET['page']]['fields']);

        foreach($fields as $field) {
            $field_info = $Proj->metadata[$field];

            //continue if the field does not have any action_tags at all.
            if (!$action_tags = $field_info['misc']) {
                continue;
            }

            $action_tags = preg_replace("/\s/", "", $action_tags);

            //check if @HIDE-CHOICE-BY-EVENT is among action tags.
            //did not use \Form::getValueInActionTag methods because of nested
            //quotes inside JSON.
            if (preg_match("/@HIDE-CHOICE-BY-EVENT\s*=\s*(\[.*\])/", $action_tags, $matches)) {

                    //add to settings variable if it is a valid json
                    if ($json_config = json_decode($matches[1], true)) {
                        $settings[$field] = $json_config;
                    }
            }

        }

        $current_event = \Event::getEventNameById($_GET['pid'], $_GET['event_id']);

        //make action tag configs available to js scripts
        $this->includeJs('js/init.js');
        $this->setJsSetting('settings', $settings);
        $this->setJsSetting('current_event', $current_event);

        //run script to hide field choices
        $this->includeJs('js/hide_choice_by_event.js');
    }

    /**
     * Includes a local JS file.
     *
     * @param string $path
     *   The relative path to the js file.
     */
    protected function includeJs($path) {
        echo '<script src="' . $this->getUrl($path) . '"></script>';
    }

    /**
     * sets a value in the global variable created by init.js
     *
     * @param string $path
     *   The relative path to the js file.
     */
    protected function setJsSetting($key, $value) {
        echo '<script>hideChoiceByEvent.' . $key . ' = ' . json_encode($value) . ';</script>';
    }
}

?>
