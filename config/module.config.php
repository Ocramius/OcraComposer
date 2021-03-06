<?php
return array(
    'ocra_composer' => array(
        // File generated by composer and that provides autoloading
        'autoload_file_path' => 'vendor/autoload.php',
        // Path from which composer will be fetched if not available on the system
        'installer_download_location' => 'http://getcomposer.org/installer',
        // Path where composer is located after installation (usually $application/vendor/.composer)
        'installation_directory' => 'vendor/.composer',
        // File name where the composer installer will be placed if composer wasn't installed
        'installer_filename' => 'install-composer.php',
        // Download the composer installer automatically if composer autoloader wasn't detected
        'automatically_download_installer' => true,
    )
);