<?php

namespace HideChoiceByEvent\ExternalModule;

use ExternalModules\AbstractExternalModule;
use ExternalModules\ExternalModules;


/**
 * ExternalModule class for Project Ownership module.
 */
class ExternalModule extends AbstractExternalModule
{

    /**
     * @inheritdoc
     */
    function redcap_every_page_top($project_id)
    {
        if ($project_id) {
            $this->includeJs('js/modify_help_menu.js');
        }

        //if not on a data entry page or survey, then don't do anything
        if (!in_array(PAGE, ['DataEntry/index.php', 'surveys/index.php'])) {
            return;
        }

        global $Proj;
        $settings = [];

        //get the name of every field on this page.
        $fields = empty($_GET['page']) ? [] : $Proj->forms[$_GET['page']]['fields'];
        if (is_array($fields)) {
            foreach (array_keys($fields) as $field) {
                $field_info = $Proj->metadata[$field];
                $misc = $field_info['misc'];

                //continue if the field does not have any action_tags at all.
                if (!$action_tags = str_replace("\n", '', $misc)) {
                    continue;
                }

                //check if @HIDE-CHOICE-BY-EVENT is among action tags.
                //did not use \Form::getValueInActionTag methods because of nested
                //quotes inside JSON.
                if (preg_match('/@HIDE-CHOICE-BY-EVENT\s*=\s*(\[)/', $action_tags, $matches, PREG_OFFSET_CAPTURE)) {
                    $count = 1;
                    $json_start = $matches[1][1];
                    $json_len = 0;
                    $len = strlen($action_tags);

                    for ($i = $json_start + 1; $i < $len; $i++) {
                        if ($action_tags[$i] == '[') {
                            $count++;
                        } elseif ($action_tags[$i] == ']' && !--$count) {
                            $json_len = $i - $json_start + 1;
                            break;
                        }
                    }

                    if (!$json_len) {
                        continue;
                    }

                    //add to settings variable if it is a valid json
                    if ($json_config = json_decode(substr($action_tags, $json_start, $json_len), true)) {
                        $settings[$field] = $json_config;
                    }
                }
            }
        }

        if (empty($settings)) {
            return;
        }

        $current_event = \Event::getEventNameById($_GET['pid'], $_GET['event_id']);

        //make action tag configs available to js scripts
        $js_settings = array(
            "settings" => $settings,
            "current_event" => $current_event
        );
        $this->setJsSettings($js_settings);

        //run script to hide field choices
        $this->includeJs('js/hide_choice_by_event.js');
    }

    /**
     * Includes a local JS file.
     *
     * @param string $path
     *   The relative path to the js file.
     */
    protected function includeJs($path)
    {
        echo '<script src="' . $this->getUrl($path) . '"></script>';
    }

    /**
     * sets a value in the global variable js variable
     * called hideChoiceByEvent.
     *
     * @param array $settings
     *   an array of keys and values.
     */
    protected function setJsSettings($settings)
    {
        echo '<script>var hideChoiceByEvent = ' . json_encode($settings) . ';</script>';
    }
}
