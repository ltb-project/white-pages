vCard export
============

When displaying an entry, it is possible to export it as vCard. If the feature is activated, a new button is displayed under the other information.

.. tip:: The vCard format is a standard, you can get more information here: https://en.wikipedia.org/wiki/VCard. 

Activation
----------

Enable or disable this feature :

.. code-block:: php

    $use_vcard = true;

vCard parameters
----------------

Set the vCard version :

.. code-block:: php

    $vcard_version = "4.0";

Configure the file name :

.. code-block:: php

    $vcard_file_extension = "vcf";
    $vcard_file_identifier = "identifier";

Map the vCard fields to White Pages items (configured in attributes map) :

.. code-block:: php

    $vcard_map = array('FN' => 'fullname', 'N' => 'fullname', 'EMAIL' => 'mail', 'CATEGORIES' => 'businesscategory', 'ORG' => 'organization', 'ROLE' => 'employeetype', 'TEL;TYPE=work,voice;VALUE=uri:tel' => 'phone', 'TEL;TYPE=cell,voice;VALUE=uri:tel' => 'mobile', 'UID' => 'identifier');
