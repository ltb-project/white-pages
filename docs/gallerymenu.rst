Gallery menu
============

The gallery feature list all photos with the user's names.

The gallery is displayed in menu. 

Activation
----------

Enable or disable this feature :

.. code-block:: php

    $use_gallery = true;

.. warning:: You should not enable this feature on a large directory as all (or a lot of) entries are displayed.

Display
-------

Set which item is used as footer title :

.. code-block:: php

    $gallery_title = "fullname";

Set on which item results are sorted :

.. code-block:: php

    $gallery_sortby = "lastname";

Define bootstrap_ column class :

.. _bootstrap: http://getbootstrap.com/css/#grid

.. code-block:: php

    $gallery_bootstrap_column_class = "col-xs-6 col-sm-4 col-md-3";

Truncate title to fit in box foot :

.. code-block:: php

    $gallery_truncate_title_after = "25";

Filter
-------

Gallery page uses the default LDAP user filter. But you can override it, for example to display entries that have the jpegPhoto attribute :

.. code-block:: php

    $gallery_user_filter = "(&".$ldap_user_filter."(jpegPhoto=*))";
