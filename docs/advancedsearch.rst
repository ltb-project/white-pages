Advanced search
===============

.. note:: Configuration file: ``white-pages/conf/config.inc.local.php``

The advanced search feature allows to search on multiple attributes (attribute1 and attribute2 and …) with a substring matching (default), an exact matching (through checkboxes) and an ordering matching (for dates).

The advanced search button is displayed in menu.

Activation
----------

Enable or disable this feature :

.. code-block:: php

    $use_advanced_search = true;

Criteria
--------

List items that are available in search form :

.. code-block:: php

    $advanced_search_criteria = array('firstname', 'lastname', 'mail', 'title', 'businesscategory', 'employeetype', 'created', 'modified');

.. note::

    The search input look is linked to the item ``type``, see Attributes.

Objects to search
-----------------

You can display radio buttons to choose which objects are searched. By default, search is done on users :

.. code-block:: php

    $advanded_search_display_search_objects = true;

If you search on groups, criteria are the same than for users.
