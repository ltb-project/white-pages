Apache configuration
====================

Virtual host
------------

.. tip:: Debian and RPM packages already include Apache configuration

Here is an example of Apache configuration using a virtual host:

.. code-block:: apache
   
    <VirtualHost *:80>
       ServerName wp.example.com

       DocumentRoot /usr/share/white-pages/htdocs
       DirectoryIndex index.php

       <Directory /usr/share/white-pages/htdocs>
           AllowOverride None
           <IfVersion >= 2.3>
               Require all granted
           </IfVersion>
           <IfVersion < 2.3>
               Order Deny,Allow
               Allow from all
           </IfVersion>
       </Directory>

       LogLevel warn
       ErrorLog /var/log/apache2/wp_error.log
       CustomLog /var/log/apache2/wp_access.log combined
    </VirtualHost>

You have to change the server name to fit your own domain configuration.

This file should then be included in Apache configuration.

.. tip:: With Debian package, just enable the site like this: a2ensite white-pages

You can also configure White Pages in the default virtual host:

.. code-block:: apache

    Alias /wp /usr/local/white-pages/htdocs
    <Directory /usr/local/white-pages/htdocs>
           DirectoryIndex index.php
           AllowOverride None
           <IfVersion >= 2.3>
               Require all granted
           </IfVersion>
           <IfVersion < 2.3>
               Order Deny,Allow
               Allow from all
           </IfVersion>
    </Directory>

Check you configuration and reload Apache:

.. prompt:: bash #

   apachectl configtest
   apachectl reload
