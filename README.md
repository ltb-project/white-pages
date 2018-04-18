# White Pages

[![Build Status](https://travis-ci.org/ltb-project/white-pages.svg?branch=master)](https://travis-ci.org/ltb-project/white-pages)

## Presentation

White Pages is a PHP application that allows users to search and display data stored in an LDAP directory.

The application can be used on standard LDAPv3 directories and Active Directory, as all searched attributes can be set in configuration.

![Screenshot](https://ltb-project.org/_media/documentation/white-pages/0.2/wp_0_2_directory.png?w=800&h=495&tok=859143)
![Screenshot](https://ltb-project.org/_media/documentation/white-pages/0.2/wp_0_2_full_display.png?w=800&h=553&tok=fec757)



It has the following features:
* Quick search: a simple input in menu bar searching on some classic attributes
* Advanced search: a full form to search on several attributes
* Directory: display of all entries in a table form
* Gallery: display of all entries with their photo
* Search and display groups and members
* Export results as CSV
* Export entry as vCard

## Demonstration

Check [Star Pages](http://ltb-project.org/star-pages/), an online demonstration of LDAP Tool Box White Pages.

## Prerequisite

* PHP >= 5.6 (for ldap_escape function)
* PHP extensions required:
  * php-ldap
  * php-gd
* Smarty 3

## Documentation

Documentation is available on http://ltb-project.org/wiki/documentation/white-pages

## Download

Tarballs and packages for Debian and Red Hat are available on http://ltb-project.org/wiki/download#white_pages
