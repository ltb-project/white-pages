Attributes
==========

To configure how LDAP attributes are displayed or searched, use the ``$attributes_map`` parameter which is an array of arrays, with this structure:

* $attributes_map :

  * item : item identifier

    * ``attribute`` : name of LDAP attribute, in lower case
    * ``faclass`` : name of Font Awesome icon class
    * ``type`` : type of attribute (see below)

The following table shows how ``type`` are used :

+-------------------+-------------------------------------------------+--------------------------------+----------------------+
| Type              | Display                                         | Search                         | Substring matching   |
+===================+=================================================+================================+======================+
| text              | Simple text                                     |  Text input                    | Yes                  |
+-------------------+-------------------------------------------------+--------------------------------+----------------------+
| mailto            | Link mailto                                     |  Text input                    | Yes                  |
+-------------------+-------------------------------------------------+--------------------------------+----------------------+
| dn_link           | Link on user entry                              |  Text input                    | No                   |
+-------------------+-------------------------------------------------+--------------------------------+----------------------+
| group_dn_link     | Link on group entry                             |  Text input                    | No                   |
+-------------------+-------------------------------------------------+--------------------------------+----------------------+
| usergroup_dn_link | Link on user or group entry                     |  Text input                    | No                   |
+-------------------+-------------------------------------------------+--------------------------------+----------------------+
| boolean           | “Yes” or “No”                                   |  Select                        | N/A                  |
+-------------------+-------------------------------------------------+--------------------------------+----------------------+
| date              | Formatted date                                  |  Calendar (“from” and “to”)    | N/A                  |
+-------------------+-------------------------------------------------+--------------------------------+----------------------+
| tel               | Link tel (click to call)                        |  Text input                    | Yes                  |
+-------------------+-------------------------------------------------+--------------------------------+----------------------+
| guid              | Simple text (objectGUID converted to string)    |  Text input                    | No                   |
+-------------------+-------------------------------------------------+--------------------------------+----------------------+
| list              | Simple text                                     |  Select                        | Yes                  |
+-------------------+-------------------------------------------------+--------------------------------+----------------------+

Example :

.. code-block:: php

    $attributes_map = array(
        'businesscategory' => array( 'attribute' => 'businesscategory', 'faclass' => 'briefcase', 'type' => 'text' ),
        'carlicense' => array( 'attribute' => 'carlicense', 'faclass' => 'car', 'type' => 'text' ),
        'created' => array( 'attribute' => 'createtimestamp', 'faclass' => 'clock-o', 'type' => 'date' ),
        'manager' => array( 'attribute' => 'manager', 'faclass' => 'user-circle-o', 'type' => 'dn_link' ),
        'member' => array( 'attribute' => 'member', 'faclass' => 'user', 'type' => 'usergroup_dn_link' ),
    );
     
    $attributes_list = array(
        'organizationalunit' => array('base'=>'ou=services,dc=example,dc=com','filter'=>'(objectClass=organizationalUnit)','key'=>'description','value'=>'ou'),
    );

To add a new definition to existing ones :

.. code-block:: php

    $attributes_map['fax'] = array( 'attribute' => 'facsimiletelephonenumber', 'faclass' => 'fax', 'type' => 'text' );

To manage a list, you need to define how keys and values are searched in LDAP directory, for example :

.. code-block:: php

    $attributes_map['organizationalunit]' = array( 'attribute' => 'ou', 'faclass' => 'building-o', 'type' => 'list' );
    $attributes_list['organizationalunit'] = array('base'=>'ou=services,dc=example,dc=com', 'filter'=>'(objectClass=organizationalUnit)', 'key'=>'description', 'value'=>'ou');
    );

The attribute set in ``key`` will be used as select key, and the attribute set in ``value`` will be used as select value.

.. tip:: 

    You can translate attribute label by defining the ``label_item`` messages in custom lang file, for example :
    
    .. code-block:: php

        $messages["label_fax"] = "Fax";

.. warning::

    Don't forget to put your LDAP attribute in lower case ! 
