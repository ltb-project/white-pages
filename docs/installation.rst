Installation
============

From tarball
------------

Tarball can be downloaded from this page. Choose the file with the .tar.gz extension.

Uncompress and unarchive the tarball: 

.. prompt:: bash #

   tar zxvf ltb-project-white-pages-VERSION.tar.gz

Install files in ``/usr/local/`` (or wherever you choose):

.. prompt:: bash #

   mv ltb-project-white-pages-VERSION /usr/local/white-pages

Adapt ownership of Smarty cache repositories so Apache user can write into them. For example: 

.. prompt:: bash #

   chown apache:apache /usr/local/white-pages/cache
   chown apache:apache /usr/local/white-pages/templates_c

You need to install these prerequisites:

* Apache or another web server
* php (version 5.6 or higher)
* php-ldap
* php-gd
* Smarty (version 3)

Debian / Ubuntu
---------------

Configure the repository:

.. prompt:: bash #

    vi /etc/apt/sources.list.d/ltb-project.list

.. code-block:: ini

    deb [arch=amd64] https://ltb-project.org/debian/stable stable main

Import repository key:

.. prompt:: bash #

    wget -O - https://ltb-project.org/wiki/lib/RPM-GPG-KEY-LTB-project | sudo apt-key add -

Then update:

.. prompt:: bash #

    apt update

You are now ready to install:

.. prompt:: bash #

    apt install white-pages

You can also do it manually :

Debian package can be downloaded from this page. Choose the file with the .deb extension. : https://ltb-project.org/download#white-pages

Install it:

.. prompt:: bash #

   dpkg -i white-pages_VERSION_all.deb

You will maybe be asked to install dependencies before: 

.. prompt:: bash #

   apt install apache2 php php-ldap php-gd smarty3

CentOS / RedHat
---------------

.. warning:: You may need to install first the package `php-Smarty`_ which is not in official repositories.

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

    yum update

Import repository key:

.. prompt:: bash #

    rpm --import https://ltb-project.org/wiki/lib/RPM-GPG-KEY-LTB-project

You are now ready to install:

.. prompt:: bash #

    yum install white-pages

You can also do it manually :

RPM can be downloaded from this page. Choose the file with the .rpm extension: https://ltb-project.org/download#white-pages

You should import LTB GPG key first: 

.. prompt:: bash #

   rpm --import http://ltb-project.org/wiki/lib/RPM-GPG-KEY-LTB-project

Install the package:

.. prompt:: bash #

   yum localinstall white-pages-VERSION.noarch.rpm

Dependencies should be installed automatically by yum. 
