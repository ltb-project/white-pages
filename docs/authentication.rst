Authentication
==============

White pages do not require authentication by default, but it can be enabled if needed:

.. code-block:: php

   $require_auth = true;

You can then choose wich authentication method to use:

* **LDAP**: use login and password to authenticate user on LDAP directory
* **SSO**: check an HTTP header to get user login, and check the entry in LDAP directory 

LDAP
----

Enable LDAP authentication backend:

.. code-block:: php

   $auth_type = "ldap";

Then configure login attribute and login filter:

.. code-block:: php

   $ldap_login_attribute = "uid";
   $ldap_login_filter = "(&$ldap_user_filter($ldap_login_attribute={login}))";

Other options are documented in :doc:`LDAP parameters page <ldap-parameters>`.

Header (SSO)
------------

Enable SSO (HTTP header) authentication backend:

.. code-block:: php

   $auth_type = "header";

Define the name of HTTP header containing the user login:

.. code-block:: php

   $auth_header_name_user = "Auth-User";
