Entries display
===============

Display mode
------------

Set which mode is used to display results when doing a quick search or an advanced search :

.. code-block:: php

    $results_display_mode = "boxes";  // boxes or table

.. warning:: This parameter doesn't change display of Directory (table) and Gallery (boxes) menus.

When displaying search results with table mode, columns are made from :

* ``$search_result_title`` and ``$search_result_items`` for users
* ``$search_result_title`` and ``$search_result_group_items`` for groups

DataTables
----------

DataTables_ plugin is used to sort, paginate, filter and print results returned by Quick search, Advanced search and Directory menu.

.. _DataTables: https://datatables.net/

Activation
^^^^^^^^^^

Enable or disable the DataTables JS component in application :

.. code-block:: php

    $use_datatables = true;

Pagination
^^^^^^^^^^

Define pagination values in dropdown :

.. code-block:: php

    $datatables_page_length_choices = array_(10, 25, 50, 100, -1); // -1 means All

.. _array: http://www.php.net/array

Set default pagination for results (can also be used to force the length without ``$datatables_page_length_choices``) :

.. code-block:: php

    $datatables_page_length_default = 10;

Print
~~~~~

Show "print all" button:

.. code-block:: php

    $datatables_print_all = true;

Show "print page" button:

.. code-block:: php

    $datatables_print_page = true;

Enable autoPrint feature (will launch print dialog directly when cliking on print buttons):

.. code-block:: php

    $datatables_auto_print = true;

Display results
---------------

List which items are shown in result box or in result table :

.. code-block:: php

    // for users
    $search_result_items = array('mail', 'phone', 'mobile');
     
    // for groups
    $search_result_group_items = array('fullname','description');

.. note:: The items identifiers are those defined in attributes map.

Set which item is used as result box title or as first column in result table :

.. code-block:: php

    $search_result_title = "fullname";

Set on which item results are sorted :

.. code-block:: php

    $search_result_sortby = "lastname";

List which items are clickable in result (can also be a boolean value) :

.. code-block:: php

    // Other possible values :
    // true if you want the whole row clickable ; 
    // false do the same and hide the button in the first column.
    $search_result_linkto = array("fullname");

Display or not undefined values :

.. code-block:: php

    $search_result_show_undefined = true;

Define bootstrap_ column class :

.. _bootstrap: http://getbootstrap.com/css/#grid

.. code-block:: php

    $search_result_bootstrap_column_class = "col-md-4";

Truncate values to fit in result box :

.. code-block:: php

    $search_result_truncate_value_after = "20";

Truncate title to fit in box head :

.. code-block:: php

    $search_result_truncate_title_after = "30";
