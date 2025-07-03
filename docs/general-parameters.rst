General parameters
==================

Configuration files
-------------------

To configure White Pages, you need to create a local configuration file named ``config.inc.local.php`` in ``white-pages/conf``. For example : 

.. code-block:: php

    <?php
    // Override config.inc.php parameters below

    ?>

White Pages default configuration file is ``white-pages/conf/config.inc.php``. It includes ``config.inc.local.php``. Consequently, you can override all parameters in ``config.inc.local.php``. This prevents you to be disturbed by an upgrade.

.. warning:: 
  Do not copy ``config.inc.php`` into ``config.inc.local.php``, as the first one includes the second.
  You would then create an infinite loop and crash your application.

Multi tenancy
-------------

You can load a specific configuration file by passing a HTTP header.
This feature is disabled by default. To enable it:

.. code-block:: php

   $header_name_extra_config = "WP-Extra-Config";

Then if you send the header ``WP-Extra-Config: domain1``, the file
``conf/config.inc.domain1.php`` will be loaded.

Using Apache, we may set such header using the following:

.. code-block:: apache

    <VirtualHost *:80>
       ServerName wp.domain1.com
       RequestHeader setIfEmpty WP-Extra-Config domain1
       [...]
    </VirtualHost>

Using Nginx, we could use instead:

.. code-block:: nginx

   server {
       [...]
       location ~ \.php {
           fastcgi_param WP-Extra-Config domain1;
           [...]
       }

Language
--------

.. tip:: Lang is selected from browser configuration. If no matching language is found, the default language is used.

Set default language in ``$lang``:

.. code-block:: php

    $lang = "en";

Available languages are:

* English (en)
* French (fr)
* Italian (it)

.. tip:: You can override messages by creating lang files in ``conf/``, for example ``conf/en.inc.php``.

In order to restrict languages to a specific set add ``$allowed_lang`` array as follows:

.. code-block:: php

   $allowed_lang = array("en");

Dates
-----

You can adapt how dates are displayed with specifiers (see `strftime reference`_):

.. _strftime reference: https://www.php.net/strftime

.. code-block:: php

    $date_specifiers = "%Y-%m-%d %H:%M:%S (%Z)";

Graphics
--------

Logo
^^^^

You change the default logo with your own. Set the path to your logo in ``$logo``:

.. code-block:: php

    $logo = "images/ltb-logo.png";

Background
^^^^^^^^^^

You change the background image with your own. Set the path to image in ``$background_image``:

.. code-block:: php

     $background_image = "images/unsplash-space.jpeg";

Hover effect
^^^^^^^^^^^^

You can define which `Hover`_ effect is applied to search result and gallery boxes:

.. _Hover: http://ianlunn.github.io/Hover/

.. code-block:: php

    $hover_effect = "grow";

Custom CSS
^^^^^^^^^^

To easily customize CSS, you can use a separate CSS file:

.. code-block:: php

    $custom_css = "css/custom.css";

Footer 
^^^^^^

You can hide the footer bar:

.. code-block:: php

    $display_footer = false;

Custom templates
^^^^^^^^^^^^^^^^

If you need to do more changes on the interface, you can create a custom templates directory
and override any of template file by copying it from ``templates/`` into the custom directory
and adapt it to your needs:

.. code-block:: php

    $custom_tpl_dir = "templates_custom/";

To define a custom template paramter, create a config parameter with ``tpl_`` prefix:

.. code-block:: php

   $tpl_mycustomparam = true;

And then use it in template:

.. code-block:: html

   <div>
   {if $mycustomparam}
   <p>Display this</p>
   {else}
   <p>Display that</p>
   {/if}

Default page
^^^^^^^^^^^^

By default, the welcome page is displayed. To change this:

.. code-block:: php

    $default_page = "gallery";

Debug
-----

You can turn on debug mode with ``$debug``:

.. code-block:: php

    $debug = true;

.. tip:: Debug messages will be printed in server logs.

This is also possible to enable Smarty debug, for web interface issues:

.. code-block:: php

    $smarty_debug = true;

.. tip:: Debug messages will appear on web interface.

Smarty
------

You need to define where Smarty is installed:

.. code-block:: php

    define("SMARTY", "/usr/share/php/smarty3/Smarty.class.php");

You can also configure cache directories:

.. code-block:: php

    $smarty_compile_dir = "/var/cache/white-pages/templates_c";
    $smarty_cache_dir = "/var/cache/white-pages/cache";

.. tip:: These directories must be writable by system user running the php code.
