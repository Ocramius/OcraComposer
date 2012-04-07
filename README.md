# OcraComposer

This module aims to provide (for now) simple autoloading for [Composer](https://github.com/composer/composer) based
[Zend Skeleton Application](https://github.com/zendframework/ZendSkeletonApplication) installations.

# Usage

  1. Setup a `composer.json` file in your application, add this module
     ([ocramius/OcraComposer](http://packagist.org/packages/ocramius/OcraComposer)) and any number of other modules
     as it's dependencies.
  2. Setup your `config/application.config.php` to load the `OcraComposer` module
  3. Add `vendor/ocramius` to your module paths in `config/application.config.php`


