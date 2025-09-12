Update informations
===================

To let connected user update its own information, enable this feature:

.. code-block:: php

   $use_updateinfos = true;

.. warning::

   This requires to enable authentication, see :doc:`authentication configuration page <authentication>`.

Items
_____

The list of items that are available for modification is configured in:

.. code-block:: php

   $update_items = array('firstname', 'lastname', 'mail', 'phone', 'mobile');

.. tip::

   Be sure not to put the item corresponding to the RDN of the entry, as this will raise an error.

Macros
------

Some fields can be automatically updated:

.. code-block:: php

   $update_items_macros = array('fullname' => '%firstname% %lastname%');

Photo
-----

To let user update its photo:

.. code-block:: php

   $update_photo = false;

To configure maximum file size:

.. code-block:: php

   $update_photo_maxsize = 500000;

Depending on where is stored the photo, adjust these settings:

.. code-block:: php

   $update_photo_ldap = true;
   $update_photo_directory = false;

.. tip::

   The parameters for photo storage are available in the :doc:`photos section <photos>`.
