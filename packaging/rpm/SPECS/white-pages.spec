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
%define wp_name	    white-pages
%define wp_realname	ltb-project-%{name}
%define wp_version	0.1
%define wp_destdir  /usr/share/%{name}

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
White Pages is provided by LDAP Tool Box project: http://ltb-project.org

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
* Tue Nov 22 2016 - Clement Oudot <clem@ltb-project.org> - 0.1-1
- First release
