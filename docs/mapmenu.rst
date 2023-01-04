Map menu
========

The map feature list show all people's location on a world map.

The map is displayed in menu.

Activation
----------

Enable or disable this feature :

.. code-block:: php

    $use_map = true;

.. warning:: You should not enable this feature on a large directory as all (or a lot of) entries are displayed.

.. warning:: You should install PHP APCu extension for better map performance and address geocoding cache.

To avoid hitting rate limit on geocoding api, you can use cli script ``bin/map_preload_geocoding_cache.php`` to gocode all addresses and
preload cache with a 1 second delay between each geocoding call. This way the geocoding cache will be preloaded and only changed addresses will
be requested to the geocoding API on map display, leading to faster map rendering.
This should be done each time your php process is restarted, so the best way is to add it to cron.

.. code-block::

    $ bin/map_preload_geocoding_cache.php
    . geocode and store address if needed: 20 W 34th St. New York, NY 10001 United States of America
    . geocode and store address if needed: 400 Broad St. Seattle, WA 98109 United States of America
    . geocode and store address if needed: 5905 Wilshire Blvd. Los Angeles, CA 90036 United States of America
    . geocode and store address if needed: 1007 York Street Denver, CO 80206 United States of America
    . geocode and store address if needed: 1007 York Street Denver, CO 80206 United States of America
      . Already in cache, skipping rate limit wait


Map tiles and geocoding API
---------------------------

The default configuration uses OpenStreetMap tile server and geocoding API. You can select onother OSM tile server or geocoding API :

.. code-block:: php

    $map_tileserver = 'https://tile.openstreetmap.org/{z}/{x}/{y}.png';
    $map_attribution = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';
    $map_geocode_url = 'https://nominatim.openstreetmap.org/search?format=json&limit=1&q=%s';

Display
-------

Choose between default markers (``false``) or markers with photo (``true``) :

.. code-block:: php

    $map_display_photos_as_marker = true;

Select which attributes will be used as full name on user details popup :

.. code-block:: php

    $map_fullname_items = array('firstname', 'lastname');

Select which additional data you want to show on user details popup :

.. code-block:: php

    $map_additional_items = array('title');

Select address format as an array, one item for each line, and line as an array if multiple properties should be combined :

.. code-block:: php

    $map_address_format = array('street', array('l', 'postalcode'), 'state');

If you want to place people without address information to a default location, you can configure :

.. code-block:: php

    $map_no_location_show_on_default = true;
    $map_default_location_lat = 48.6882405;
    $map_default_location_long = -32.6412127;

Filter
-------

Map page uses the default LDAP user filter. But you can override it, for example to display entries that have the jpegPhoto attribute :

.. code-block:: php

    $map_user_filter = "(&".$ldap_user_filter."(jpegPhoto=*))";
