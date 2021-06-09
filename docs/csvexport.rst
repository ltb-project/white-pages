CSV export
==========

The gallery feature list all photos with the user's names.

The gallery is displayed in menu. 

Activation
----------

Enable or disable this feature :

.. code-block:: php

    $use_csv = true;

File name
---------

Set the CSV file name :

.. code-block:: php

    $csv_filename = "white_pages_export_" . date("Y-m-d") . ".csv";

Items
-----

List the items that will be put in CSV file :

.. code-block:: php

    $csv_items = array('firstname', 'lastname', 'mail','organization');

.. tip:: 

    To have same fields between Advanced search menu and CSV export :
    
    .. code-block:: php

        $csv_items = $search_result_items;
