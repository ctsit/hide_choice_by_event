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
        }
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

}

?>
