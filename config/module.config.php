<?php
return array(
    'composer' => array(
        // Path from which composer will be fetched if not available on the system
        'installer_download_location' => 'http://getcomposer.org/installer',
        // Path where composer is located after installation (usually $application/vendor/.composer)
        'installation_directory' => 'vendor/.composer',
        // File generated by composer and that provides autoloading
        'autoload_file' => 'autoload.php',
        // File name where the composer installer will be placed if composer wasn't installed
        'installer_filename' => 'install-composer.php',
    )
);