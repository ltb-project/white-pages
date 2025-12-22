Patterns
========

You can define a pattern to control edition of any attribute.

By default no patterns are defined. You can create one by adding a property in attributes map and a message in the custom lang file by setting the ``pattern_item`` message.

For example to add a pattern on phone item:

* Edit or create ``/etc/service-desk/config.local.inc.php``:

.. code-block:: php

   $attributes_map['phone']['pattern'] = "\+33 [0-9] [0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2}";

* Edit or create ``/etc/service-desk/fr.inc.php``:

.. code-block:: php

   $messages['pattern_phone'] = "+33 1 23 45 67 89";
