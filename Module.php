<?php

namespace OcraComposer;

use UnexpectedValueException;
use RuntimeException;
use Zend\Module\Manager;

class Module
{
    /**
     * @var null|array
     */
    protected $config = null;

    /**
     * @param \Zend\Module\Manager $moduleManager
     * @throws \RuntimeException
     */
    public function init(Manager $moduleManager)
    {
        $config = $this->getConfig();

        if(!@include_once $config['ocra_composer']['autoload_file_path']) {
            $installer = realpath($config['ocra_composer']['installer_filename']);
            $installer = $installer ? $installer : $this->downloadComposerInstaller($config);

            throw new RuntimeException(
                'Could not locate "'
                    . $config['ocra_composer']['autoload_file_path'] . "\", "
                    . "you probably didn't install all required project dependencies.\n"
                    . 'Composer has been downloaded to "' . $installer . "\".\n"
                    . 'Install it by running `php ' . $config['ocra_composer']['installer_filename'] . "`, "
                    . 'then install dependencies by running `php composer.phar install`.'
            );
        }
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        if (!$this->config) {
            $this->config = include __DIR__ . '/config/module.config.php';
        }

        return $this->config;
    }

    protected function downloadComposerInstaller($config)
    {
        if (!$config['ocra_composer']['automatically_download_installer']) {
            throw new RuntimeException(
                'Could not locate "'
                . $config['ocra_composer']['autoload_file_path'] . "\", "
                . "you probably didn't install all required project dependencies through composer.\n"
            );
        }

        if (!is_writable(getcwd())) {
            throw new RuntimeException(
                '"' . realpath(getcwd()) . '" is not writable, could not download composer installer to it'
            );
        }

        if (!$installer = @file_get_contents($config['ocra_composer']['installer_download_location'])) {
            throw new UnexpectedValueException(
                'Could not locate or download composer installer from "'
                . $config['ocra_composer']['installer_download_location'] . '"'
            );
        }

        if (!@file_put_contents($config['ocra_composer']['installer_filename'], $installer)) {
            throw new UnexpectedValueException(
                'Could not write composer installer to "' . $config['ocra_composer']['installer_filename'] . '"'
            );
        }

        if (!$installer = realpath($config['ocra_composer']['installer_filename'])) {
            throw new UnexpectedValueException(
                'Could not find downloaded composer installer "' . $config['ocra_composer']['installer_filename'] . '"'
            );
        }

        return $installer;
    }

}
