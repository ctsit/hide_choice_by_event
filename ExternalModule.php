<?php

namespace HideChoiceByEvent\ExternalModule;

use ExternalModules\AbstractExternalModule;
use ExternalModules\ExternalModules;


/**
 * ExternalModule class for Project Ownership module.
 */
class ExternalModule extends AbstractExternalModule {

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
