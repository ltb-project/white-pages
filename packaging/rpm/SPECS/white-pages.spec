#=================================================
# Specification file for White Pages
#
# Install LTB project White Pages
#
# GPL License
#
# Copyright (C) 2009-2016 Clement OUDOT
# Copyright (C) 2009-2016 LTB-project
#=================================================

#=================================================
# Variables
#=================================================
%define wp_name      white-pages
%define wp_realname  ltb-project-%{name}
%define wp_version   0.3
%define wp_destdir   /usr/share/%{name}

#=================================================
# Header
#=================================================
Summary: LDAP white pages web interface
Name: %{wp_name}
Version: %{wp_version}
Release: 1%{?dist}
License: GPL
BuildArch: noarch

Group: Applications/Web
URL: http://ltb-project.org

Source: %{wp_realname}-%{wp_version}.tar.gz
Source1: white-pages-apache.conf
BuildRoot: %{_tmppath}/%{name}-%{version}-%{release}-root-%(%{__id_u} -n)

Prereq: coreutils
Requires: php, php-ldap, php-Smarty, php-gd

%description
White Pages is a PHP application that allows users to search and display data stored in an LDAP directory. 
White Pages is provided by LDAP Tool Box project: https://ltb-project.org

#=================================================
# Source preparation
#=================================================
%prep
%setup -n %{wp_realname}-%{wp_version}

#=================================================
# Installation
#=================================================
%install
rm -rf %{buildroot}

# Create directories
mkdir -p %{buildroot}/%{wp_destdir}
mkdir -p %{buildroot}/%{wp_destdir}/cache
mkdir -p %{buildroot}/%{wp_destdir}/conf
mkdir -p %{buildroot}/%{wp_destdir}/htdocs
mkdir -p %{buildroot}/%{wp_destdir}/lang
mkdir -p %{buildroot}/%{wp_destdir}/lib
mkdir -p %{buildroot}/%{wp_destdir}/templates
mkdir -p %{buildroot}/%{wp_destdir}/templates_c
mkdir -p %{buildroot}/etc/httpd/conf.d

# Copy files
## Program
install -m 644 conf/*         %{buildroot}/%{wp_destdir}/conf
install -m 644 htdocs/*.php   %{buildroot}/%{wp_destdir}/htdocs
cp -a          htdocs/css     %{buildroot}/%{wp_destdir}/htdocs
cp -a          htdocs/images  %{buildroot}/%{wp_destdir}/htdocs
cp -a          htdocs/vendor  %{buildroot}/%{wp_destdir}/htdocs
install -m 644 lang/*         %{buildroot}/%{wp_destdir}/lang
install -m 644 lib/*          %{buildroot}/%{wp_destdir}/lib
install -m 644 templates/*    %{buildroot}/%{wp_destdir}/templates
## Apache configuration
install -m 644 %{SOURCE1}     %{buildroot}/etc/httpd/conf.d/white-pages.conf

# Adapt Smarty path
sed -i 's:/usr/share/php/smarty3:/usr/share/php/Smarty:' %{buildroot}%{wp_destdir}/conf/config.inc.php

%post
#=================================================
# Post Installation
#=================================================

# Change owner
/bin/chown apache:apache %{wp_destdir}/cache
/bin/chown apache:apache %{wp_destdir}/templates_c

#=================================================
# Cleaning
#=================================================
%clean
rm -rf %{buildroot}

#=================================================
# Files
#=================================================
%files
%defattr(-, root, root, 0755)
%config(noreplace) %{wp_destdir}/conf/config.inc.php
%config(noreplace) /etc/httpd/conf.d/white-pages.conf
%{wp_destdir}

#=================================================
# Changelog
#=================================================
%changelog
* Tue Jul 23 2019 - Clement Oudot <clem@ltb-project.org> - 0.3-1
- gh#42: add dropdown list to advanced search criteria
- gh#47: Do not display not found groups/users
- gh#48: Check ldap_bind return code instead of ldap_errorno
- gh#49: Add url link to web ldap editor tool for each users entrie
- gh#50: Provide a way to know the installed version
- gh#51: No information is displayed when opening user details in a multi-organizational DIT
- gh#52: fix(display): introducing optional `$ldap_user_regex`
- gh#54: Hide photo box if there is no picture
- gh#55: Can we get a list of all groups
- gh#58: XSS protection added
- gh#60: Sort group members
- gh#61: Adapt other templates to changes in value_displayer.tpl (ltb-project#47)
- gh#62: Set version in code and display it in footer (ltb-project#50)
- gh#63: Add buttons in directory page to switch between users and groups (ltb-project#55)
- gh#64: Set LDAP debug if $debug is set
- gh#65: Enable debug in php-ldap (ltb-project#64)
- gh#66: Sort values when displaying entry (ltb-project#60)
- gh#68: Possibility to set a specific filter for gallery (ltb-project#54)
- gh#69: Configure default page
- gh#70: Bad quote escaping in advanced search page
- gh#71: Option to add an edit link in entry display page (ltb-project#49)
- gh#72: Sorting and paging regression
- gh#73: Option to display a logout link in the menu
- gh#74: Provide a new type (list)
* Mon Apr 16 2018 - Clement Oudot <clem@ltb-project.org> - 0.2-1
- gh#4: Italian language file
- gh#5: Feature request : add export to CSV
- gh#7: Export entry as VCard
- gh#8: Doc : fix typo in "Installation from tarball"
- gh#10: Directory thumbnail frame are unformatted
- gh#11: Add a menu to display groups (based on groupofmember)
- gh#16: Print results as rows or boxes
- gh#17: Quick search return with pattern like "foo*"
- gh#18: Replace exact matching by substring matching in advanced search
- gh#21: [Security] LDAP Injection in quick search
- gh#22: Possibility to configure photo attribute
- gh#23: Create tel: links for telephone numbers
- gh#24: PHP >= 5.6 prerequisite
- gh#25: New view "directory" which display all entries in a list with datatables
- gh#26: checkboxes in advanced search form for substring matching
- gh#30: Config.inc.php : include local file and document variables
- gh#31: Configure a print button with Datatables
- gh#32: List view directory search
- gh#33: Add config option for autoPrint feature in Datatables
- gh#34: Improve browsing on pages with Datatables
- gh#35: Sort icons should be more close than their column name
- gh#36: Change icon for Directory or Gallery view
- gh#37: Logo not visible on other pages than homepage
- gh#38: Text and look for print buttons
- gh#39: Add display for member/memberOf attributes
- gh#40: Displaying binary data attributes
- gh#41: Move label to title leads to misunderstanding
* Tue Nov 22 2016 - Clement Oudot <clem@ltb-project.org> - 0.1-1
- First release
