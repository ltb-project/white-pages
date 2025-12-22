Tooltips
========

Some tooltips can be added on update info page for each item.

By default no tooltips are defined. You can create one in the custom lang file in configuration directory by setting the ``tooltip_item`` message.

For example to add a tooltip on mail item, edit or create ``/etc/white-pages/en.inc.php``:

.. code-block:: php

   $messages['tooltip_mail'] = "Please do not use a personal email";

