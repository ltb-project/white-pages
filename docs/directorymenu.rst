Directory menu
==============

.. note:: Configuration file: ``white-pages/conf/config.inc.local.php``

The directory feature list all results in a table form.

The directory is displayed in menu.

Activation
----------

Enable or disable this feature :

.. code-block:: php

    $use_directory = true;

Display
-------

List which items are shown in result table :

.. code-block:: php

    $directory_items = array('firstname', 'lastname', 'mail', 'organization');
    $directory_group_items = array('fullname', 'description');

List which items are clickable in result table (can also be a boolean value) :

.. code-block:: php

    // Other possible values :
    // true if you want the whole row clickable ; 
    // false do the same and hide the button in the first column.
    $directory_linkto = array('firstname', 'lastname');
    $directory_group_linkto = array('fullname');

Set on which item results are sorted :

.. code-block:: php

    $directory_sortby = "lastname";
    $directory_group_sortby = "fullname";

Display or not undefined values :

.. code-block:: php

    $directory_show_undefined = false;

Truncate values to fit in result table :

.. code-block:: php

    $directory_truncate_value_after = 30;

Display the buttons to switch between users and groups :

.. code-block:: php

    $directory_display_search_objects = true;
