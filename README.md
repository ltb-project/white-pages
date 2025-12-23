# White Pages

[![Build Status](https://github.com/ltb-project/white-pages/actions/workflows/ci.yml/badge.svg)](https://github.com/ltb-project/white-pages/actions/workflows/ci.yml)
[![Documentation Status](https://readthedocs.org/projects/white-pages/badge/?version=latest)](https://white-pages.readthedocs.io/en/latest/)

## Presentation

White Pages is a PHP application that allows users to search and display data stored in an LDAP directory.

The application can be used on standard LDAPv3 directories and Active Directory, as all searched attributes can be set in configuration.

![Screenshot](https://raw.githubusercontent.com/ltb-project/white-pages/master/wp_0_1_full_display.png)

It has the following features:
* Quick search: a simple input in menu bar searching on some classic attributes
* Advanced search: a full form to search on several attributes
* Directory: display of all entries in a table form
* Gallery: display of all entries with their photo
* Map: Show people location on a map
* Search and display groups and members
* Export results as CSV
* Export entry as vCard
* User can update its own information in the directory

## Demonstration

Check [Star Pages](http://ltb-project.org/star-pages/), an online demonstration of LDAP Tool Box White Pages.

## Prerequisite

* PHP >= 7.4
* PHP extensions required:
  * php-ldap
  * php-gd
* Smarty >= 3

## Documentation

Documentation is available on https://ltb-project.org/documentation/white-pages.html

## Download

Tarballs and packages for Debian and Red Hat are available on https://ltb-project.org/download.html

## Development

This repository provides a `compose.yaml` file to ease the development process.

```sh
# Build images
docker compose build

# Create local configuration
cp ./packaging/docker/dev/config.inc.local.php ./conf/

# Start dev. environment
docker compose up -d

# Create user account into LDAP
docker compose exec -T ldap ldapadd -H ldap://localhost -D cn=admin,dc=example,dc=com -w password <packaging/docker/dev/user1.ldif
```

You can now connect to the following :

- application (HTTP):
  - port:     8080
  - login:    user1
  - password: password
- directory (LDAP):
  - port:     3890
  - dn:       cn=admin,dc=example,dc=com
  - password: password
