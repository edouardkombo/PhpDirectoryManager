Php Directory Manager
=====================
 
About
-----

Php Directory Manager helps you manage directories with directoryIterator php native objects.
It will help you create, browse, copy and delete directories.

This class is fully tested with CodeCeption.


Requirements
------------

Require PHP version 5.4 or greater.


Installation
------------

Register the bundle in your composer.json

    {
        "require": {
            "edouardkombo/php-directory-manager": "dev-master"
        }
    }

Now, install the vendor

    php composer.phar install


Don't forget to execute tests
    
    codecept run unit

Documentation
-------------

    $manager = new DirectoryManager();
    $manager->setDirectoryIterator('path/to/directory');

    //Move content to another directory
    $manager->move('path/to/new/directory');

    //Move a specific file to another directory
    $manager->move('path/to/new/directory', 'NameOfFileToMove');

    //Delete all directory content
    $manager->delete('path/to/new/directory');

    //Delete specific file
    $manager->delete('NameOfFileToDelete');

Contributing
-------------

If you want to help me improve this bundle, please make sure it conforms to the PSR coding standard. The easiest way to contribute is to work on a checkout of the repository, or your own fork, rather than an installed version.

Issues
------

Bug reports and feature requests can be submitted on the [Github issues tracker](https://github.com/edouardkombo/PhpDirectoryManager/issues).

For further informations, contact me directly at edouard.kombo@gmail.com.

