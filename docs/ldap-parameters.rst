LDAP parameters
===============

.. note:: Configuration file: ``white-pages/conf/config.inc.local.php``

Server address
--------------

Use an LDAP URI to configure the location of your LDAP server in ``$ldap_url``:

.. code-block:: php

    $ldap_url = "ldap://localhost:389";

You can set several URI, so that next server will be tried if the previous is down:

.. code-block:: php

    $ldap_url = "ldap://server1 ldap://server2";

To use SSL, set ldaps in the URI:

.. code-block:: php

    $ldap_url = "ldaps://localhost";

To use StartTLS, set ``true`` in ``$ldap_starttls``:

.. code-block:: php

    $ldap_starttls = true;

.. tip:: LDAP certificate management in PHP relies on LDAP system libraries. Under Linux, you can configure ``/etc/ldap.conf`` (or ``/etc/ldap/ldap.conf`` on Debian/Ubuntu, or ``C:\OpenLDAP\sysconf\ldap.conf`` for Windows). Provide the certificate from the certificate authority that issued your LDAP server's certificate.

Credentials
-----------

Configure DN and password in ``$ldap_bindn`` and ``$ldap_bindpw``:

.. code-block:: php

    $ldap_binddn = "cn=manager,dc=example,dc=com";
    $ldap_bindpw = "secret";

.. tip:: You can leave these parameters empty to bind anonymously.

LDAP Base
---------

You can set global base in ``$ldap_base``:

.. code-block:: php

    $ldap_base = "dc=example,dc=com";

User search parameters
----------------------

You can set base of the search in ``$ldap_user_base``:

.. code-block:: php

    $ldap_user_base = "ou=users,".$ldap_base;

The filter can be set in ``$ldap_user_filter``:

.. code-block:: php

    $ldap_user_filter = "(objectClass=inetOrgPerson)";

When an entry is displayed, to help the software to determine if this is a user, you can configure a regular expression:

.. code-block:: php

    $ldap_user_regex = "/,ou=users,/i";

.. tip:: If you don't set this value, the software will use the search base: if the entry DN is inside the user search base, then it is a user. But this method can be useless depending of your LDAP directory organization.


Group search parameters
-----------------------

You can set the base of the search in ``$ldap_group_base`` :

.. code-block:: php

    $ldap_group_base = "ou=groups,".$ldap_base;

The filter can be set in ``$ldap_group_filter`` :

.. code-block:: php

    $ldap_group_filter = "(|(objectClass=groupOfNames)(objectClass=groupOfUniqueNames))";


Size limit
----------

It is advised to set a search limit on client side if no limit is set by the server:

.. code-block:: php

    $ldap_size_limit = 100;

.. note:: This limit will also restrict the number of entries shown in the gallery menu.
