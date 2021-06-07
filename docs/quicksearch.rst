Quick search
============

.. note:: Configuration file: ``white-pages/conf/config.inc.local.php``

The quick search feature allows to search on multiple attributes (attribute1 or attribute2 or …) with a substring matching (attribute=*query*) by default or an exact matching, see $quick_search_use_substring_match below. The quick search input is located in menu bar.

Activation
----------

Enable or disable this feature :

.. code-block:: php

    $use_quick_search = true;

Search filter
-------------

Define on which LDAP attributes the search will be done :

.. code-block:: php

    $quick_search_attributes = array('uid', 'cn', 'mail');

.. note::

    With this example, the search filter for query ``test`` will be ``(|(uid=*test*)(cn=*test*)(mail=*test*))``

Exact matching
--------------

By default, as shown in the example above, the query is used as substring match. You can change this by forcing exact matching :

.. code-block:: php

    $quick_search_use_substring_match = false;

.. note::

    With this example, the search filter for query ``test`` will be ``(|(uid=test)(cn=test)(mail=test))``
