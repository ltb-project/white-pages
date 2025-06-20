Full display
============

This page is displayed when clicking on a search result, or directly if there is only one entry matching the search query.

List which items are displayed:

* For user entry :

.. code-block:: php

    $display_items = array('firstname', 'lastname', 'title', 'businesscategory', 'employeenumber', 'employeetype', 'mail', 'phone', 'mobile', 'fax', 'postaladdress', 'street', 'postalcode', 'l', 'state', 'manager', 'secretary', 'organizationalunit', 'organization', 'description' );

* For group entry :

.. code-block:: php

    $display_group_items = array('fullname', 'description', 'member', 'uniquemember', 'memberof');

Set which item is used as title :

.. code-block:: php

    $display_title = "fullname";

Display or not undefined values in full display :

.. code-block:: php

    $display_show_undefined = false;
