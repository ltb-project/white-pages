Upgrade
=======

If you upgrade from an older version, read the following instructions:

From 0.4 to 0.5
---------------

bundled dependencies
~~~~~~~~~~~~~~~~~~~~

The dependencies are now explicitly listed in the white-pages package, including the bundled ones.

You can find bundled dependencies list:

* in package description in debian package
* in Provides field in rpm package


configuration
~~~~~~~~~~~~~

The configuration files are now in ``/etc/white-pages`` directory.

During the upgrade process towards 0.5, the previous configuration files present in ``/usr/share/white-pages/conf`` (all .php files) are migrated to ``/etc/white-pages/``:

* ``config.inc.php`` is migrated as a ``config.inc.php.bak`` file,
* all other php file names are preserved. (including local conf, domain conf, and customized lang files)

Please take in consideration that ``config.inc.php`` is now replaced systematically by the version in the RPM package. A .rpmsave backup will be done with the current version. The deb package will continue asking which file to use, it is advised to replace the current one with the version in the package.

Avoid as much as possible editing the ``/etc/white-pages/config.inc.php`` file. Prefer modifying the ``/etc/white-pages/config.inc.local.php``.

cache cleaning
~~~~~~~~~~~~~~

Now the cache is being cleaned-up during white-pages upgrade / install.

This is intended to avoid smarty problems due to white-pages templates upgrade, and possibly smarty upgrade itself.


dependencies update
~~~~~~~~~~~~~~~~~~~

Removed packaged dependencies:

* old php module for apache2/httpd is no more required. The migration is done towards php-fpm.
* apache2/httpd is not required any more. You can installed nginx or httpd by hand.

Packaged dependencies:

* smarty is now a required package. white-pages will work with either version 3 or 4. On debian, ``config.inc.php`` will be configured to use smarty4 if available
* php-fpm >= 7.3 is now a required dependency, replacing old php module for apache/httpd. On debian, if apache2 is already installed, php-fpm configuration for apache2 will be done automatically
* php-ldap has been kept as dependency

Bundled dependencies:

* js-bootstrap has been updated from version 3.2.0 to version v5.3.6
* js-jquery has been updated from version v1.10.2 to version v3.7.1
* js-datatables.net-datatables.net has been updated from version 1.10.16 to version 2.1.2
* js-datatables.net-datatables.net-bs5 has been updated from version 1.10.16 to version 2.0.8
* js-datatables.net-datatables.net-buttons has been updated from version 1.5.1 to version 3.1.0
* js-datatables.net-datatables.net-buttons-bs5 has been updated from version 1.5.1 to version 3.0.2
* fontawesome-fonts has been updated from version 4.7.0 to version 6.5.2
* php-ltb-project-ltb-common has been updated from version 0.1 to version 0.5.0
* php-phpmailer has been updated from version 6.8.0 to version v6.9.1

Note that hidden files (.gitignore,...) from bundled dependencies are now removed from packages.


From 0.3 to 0.4
---------------

* Parameter `$ldap_user_regex` is now disbaled by default, means that the object type detection is done with configured LDAP filters.

* The new map feature is disabled by default, as it requires to request OpenStreetMap API. Check the documentation before enabling it.

From 0.2 to 0.3
---------------

There is a new parameter: `$ldap_user_regex`.

If the default value does not fit your LDAP directory configuration, you must unset the default value, or adapt it. To unset it, put in your config.inc.local.php:

```unset($ldap_user_regex);```

See also the ldap parameters page.
