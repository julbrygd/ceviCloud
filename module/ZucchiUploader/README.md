ZucchiUploader
==============

Module to provide integration of PLUpload (http://www.plupload.com/)

Installation
------------

From the root of your ZF2 Skeleton Application run

    ./composer.phar require zucchi/uploader
    
This module will require your vhost to use an AliasMatch

    AliasMatch /_([^/]+)/(.+)/([^/]+) /path/to/vendor/$2/public/$1/$3

Roadmap
-------

*    Create view helper to utilise Queue Widget