<?php

namespace OcraComposer;

use UnexpectedValueException;
use RuntimeException;
use Zend\Module\Manager;

class Module
{
    public function init(Manager $moduleManager)
    {
        $moduleManager->events()->attach('loadModules.post', array($this, 'modulesLoaded'));
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function modulesLoaded($e)
    {
        $config = $e->getConfigListener()->getMergedConfig();

        $autoloadFile = $config->composer->installation_directory . '/' . $config->composer->autoload_file;

        if (!@include $autoloadFile) {

            $installer = realpath($config->composer->installer_filename);
            $installer = $installer ? $installer : $this->downloadComposerInstaller($config);

            throw new RuntimeException(
                'Could not locate "'
                . $config->composer->installation_directory . '/' . $config->composer->autoload_file . "\", "
                . "you probably didn't install all required project dependencies.\n"
                . 'Composer has been downloaded to "' . $installer . "\".\n"
                . 'Install it by running `php ' . $config->composer->installer_filename . "`, "
                . 'then install dependencies by running `php composer.phar install`.'
            );
        }
    }

    protected function downloadComposerInstaller($config)
    {
        if(!is_writable(getcwd())) {
            throw new RuntimeException(
                '"' . realpath(getcwd()) . '" is not writeable, could not download composer installer to it'
            );
        }

        if (!$installer = @file_get_contents($config->composer->installer_download_location)) {
            throw new UnexpectedValueException(
                'Could not locate or download composer installer from "'
                . $config->composer->installer_download_location . '"'
            );
        }

        if(!@file_put_contents($config->composer->installer_filename, $installer)) {
            throw new UnexpectedValueException(
                'Could not write composer installer to "' . $config->composer->installer_filename . '"'
            );
        }

        if(!$installer = realpath($config->composer->installer_filename)) {
            throw new UnexpectedValueException(
                'Could not find downloaded composer installer "' . $config->composer->installer_filename . '"'
            );
        }

        return $installer;
    }

}
