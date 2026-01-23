Installation
============

From tarball
------------

Prerequisites:

* php-ldap
* php-gd
* composer
* php-fpm
* smarty (version 3 or 4)

Tarball can be downloaded from `LTB project website <https://ltb-project.org/download.html>`_.

Uncompress and unarchive the tarball: 

.. prompt:: bash #

   tar zxvf ltb-project-white-pages-VERSION.tar.gz

Run composer:

.. prompt:: bash #

   cd ltb-project-white-pages-VERSION/
   composer update

Install files in ``/usr/share/white-pages`` (or wherever you choose):

.. prompt:: bash #

   mv * /usr/share/white-pages

Adapt ownership of Smarty cache repositories so Apache user can write into them. For example: 

.. prompt:: bash #

   chown apache:apache /usr/share/white-pages/cache
   chown apache:apache /usr/share/white-pages/templates_c

Debian / Ubuntu
---------------

.. Important::
    The GPG key for debian has been updated on August 2025. Take care to use the new one by following the instructions below.

.. warning:: You need to install first the package `smarty3`_. If you face the error ``syntax error, unexpected token "class"``, try to install a newer version of the package:

   ``# wget http://ftp.us.debian.org/debian/pool/main/s/smarty3/smarty3_3.1.47-2_all.deb``

   ``# dpkg -i smarty3_3.1.47-2_all.deb``

.. _smarty3: https://packages.debian.org/sid/smarty3

Import repository key:

.. prompt:: bash #

    curl https://ltb-project.org/documentation/_static/ltb-project-debian-keyring.gpg | gpg --dearmor > /usr/share/keyrings/ltb-project-debian-keyring.gpg


Configure the apt repository:

.. prompt:: bash #

    vi /etc/apt/sources.list.d/ltb-project.sources

.. code-block:: ini

    Types: deb
    URIs: https://ltb-project.org/debian/stable
    Suites: stable
    Components: main
    Signed-By: /usr/share/keyrings/ltb-project-debian-keyring.gpg
    Architectures: amd64

.. note::

    You can also use the old-style source.list format. Edit ``ltb-project.list`` and add::

        deb [arch=amd64 signed-by=/usr/share/keyrings/ltb-project-debian-keyring.gpg] https://ltb-project.org/debian/stable stable main

Then update:

.. prompt:: bash #

    apt update

You are now ready to install:

.. prompt:: bash #

    apt install white-pages

You should now proceed to :ref:`webserver installation and configuration <apache_configuration>`

CentOS / RedHat
---------------

.. warning::  You must install the package `php-Smarty`_. You can get it from EPEL repositories.

.. _php-Smarty: https://pkgs.org/download/php-Smarty

Configure the yum repository:

.. prompt:: bash #

    vi /etc/yum.repos.d/ltb-project.repo

.. code-block:: ini

    [ltb-project-noarch]
    name=LTB project packages (noarch)
    baseurl=https://ltb-project.org/rpm/$releasever/noarch
    enabled=1
    gpgcheck=1
    gpgkey=file:///etc/pki/rpm-gpg/RPM-GPG-KEY-LTB-project

Then update:

.. prompt:: bash #

    dnf update

Import repository key:

.. prompt:: bash #

    rpm --import https://ltb-project.org/documentation/_static/RPM-GPG-KEY-LTB-project

You are now ready to install:

.. prompt:: bash #

    dnf install white-pages

You should now proceed to :ref:`webserver installation and configuration <apache_configuration>`

Docker
------

Prepare a local configuration file for White Pages, for example ``/home/test/whitepages.conf.php``.

Start container, mounting that configuration file:

.. prompt:: bash #

    docker run -p 80:80 \
        -v /home/test/whitepages.conf.php:/var/www/conf/config.inc.local.php \
        -it docker.io/ltbproject/white-pages:latest

