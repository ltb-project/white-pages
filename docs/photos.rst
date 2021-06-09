Photos
======

.. note:: Configuration file: ``white-pages/conf/config.inc.local.php``

Default photo
-------------

Configure which file is used as default photo :

.. code-block:: php

    $default_photo = "images/240px-PICA.jpg";

LDAP attribute
--------------

Set the name of the LDAP attribute where photo is stored :

.. code-block:: php

    $photo_ldap_attribute = "jpegPhoto";

Fixed size
----------

It is possible to resize all photos to a defined width and/or height :

.. code-block:: php

    $photo_fixed_width = 240;
    $photo_fixed_height = 240;

Local photos
------------

This is possible to load a local photo from file if photo is not found in LDAP directory.

Directory where photo are stored (relative to htdocs/ directory) :

.. code-block:: php

    $photo_local_directory = "../photos/";

LDAP attribute that is used as photo file name :

.. code-block:: php

    $photo_local_ldap_attribute = "uid";

File extenstion (with the dot) :

.. code-block:: php

    $photo_local_extension = ".jpg";
