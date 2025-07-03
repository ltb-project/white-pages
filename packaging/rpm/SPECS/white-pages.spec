#=================================================
# Specification file for White Pages
#
# Install LTB project White Pages
#
# GPL License
#
# Copyright (C) 2009-2023 Clement OUDOT
# Copyright (C) 2009-2023 LTB-project
#=================================================

%global wp_destdir   %{_datadir}/%{name}
%global wp_cachedir  %{_localstatedir}/cache/%{name}
%define wp_realname  ltb-project-%{name}
%undefine __brp_mangle_shebangs

Name: white-pages
Version: 0.5^20250107
Release: 1%{?dist}
Summary: LDAP Tool Box White Pages web interface
License: GPL
URL: https://ltb-project.org

BuildArch: noarch

Source0: https://ltb-project.org/archives/%{wp_realname}-%{version}.tar.gz
Source1: white-pages-apache.conf

%{?fedora:BuildRequires: phpunit9}
Requires:  coreutils
Requires:  php(language) >= 7.3
Requires:  php-ldap
Requires:  php-Smarty
Requires:  php-fpm
%{!?el7:%global __requires_exclude /usr/bin/python}

Provides:  bundled(js-bootstrap) = v5.3.6
Provides:  bundled(js-jquery) = v3.7.1
Provides:  bundled(js-datatables.net-datatables.net) = 2.1.2
Provides:  bundled(js-datatables.net-datatables.net-bs5) = 2.0.8
Provides:  bundled(js-datatables.net-datatables.net-buttons) = 3.1.0
Provides:  bundled(js-datatables.net-datatables.net-buttons-bs5) = 3.0.2
Provides:  bundled(fontawesome-fonts) = 6.5.2
Provides:  bundled(php-ltb-project-ltb-common) = 0.3.0
Provides:  bundled(php-bjeavons-zxcvbn-php) = 1.3.1
Provides:  bundled(php-guzzlehttp-guzzle) = 7.8.1
Provides:  bundled(php-guzzlehttp-promises) = 2.0.2
Provides:  bundled(php-guzzlehttp-psr7) = 2.6.2
Provides:  bundled(php-mxrxdxn-pwned-passwords) = 2.1.0
Provides:  bundled(php-phpmailer) = 6.9.1
Provides:  bundled(php-psr-http-client) = 1.0.3
Provides:  bundled(php-psr-http-factory) = 1.0.2
Provides:  bundled(php-psr-http-message) = 2.0
Provides:  bundled(php-ralouphie-getallheaders) = 3.0.3
Provides:  bundled(php-symfony-deprecation-contracts) = 3.4.0
Provides:  bundled(php-symfony-finder) = 7.0.0
Provides:  bundled(php-symfony-polyfill) = v1.31.0
Provides:  bundled(php-symfony-deprecation-contracts) = v2.5.3
Provides:  bundled(php-symfony-var-exporter) = v5.4.40
Provides:  bundled(php-psr-container) = 1.1.2
Provides:  bundled(php-symfony-service-contracts) = v2.5.3
Provides:  bundled(php-psr-cache) = 1.0.1
Provides:  bundled(php-symfony-cache-contracts) = v2.5.3
Provides:  bundled(php-psr-log) = 1.1.4
Provides:  bundled(php-symfony-cache) = v5.4.42
Provides:  bundled(php-predis-predis) = v2.2.2

%description
White Pages is a PHP application that allows users to search and display data stored in an LDAP directory.
White Pages is provided by LDAP Tool Box project: https://ltb-project.org

#=================================================
# Source preparation
#=================================================
%prep
%setup -q -n %{wp_realname}-%{version}
# Clean hidden files in bundled php libs
find . \
  \( -name .gitignore -o -name .travis.yml -o -name .pullapprove.yml \) \
  -delete

#=================================================
# Installation
#=================================================
%install
# Create directories
mkdir -p %{buildroot}/%{wp_destdir}
mkdir -p %{buildroot}/%{wp_destdir}/bin
mkdir -p %{buildroot}/%{wp_destdir}/conf
mkdir -p %{buildroot}/%{wp_destdir}/htdocs
mkdir -p %{buildroot}/%{wp_destdir}/lang
mkdir -p %{buildroot}/%{wp_destdir}/lib
mkdir -p %{buildroot}/%{wp_destdir}/templates
mkdir -p %{buildroot}/%{wp_destdir}/vendor
mkdir -p %{buildroot}/%{wp_cachedir}/cache
mkdir -p %{buildroot}/%{wp_cachedir}/templates_c

# Copy files
## Program
install -m 755 bin/*          %{buildroot}/%{wp_destdir}/bin
install -m 644 htdocs/*.php   %{buildroot}/%{wp_destdir}/htdocs
cp -a          htdocs/css     %{buildroot}/%{wp_destdir}/htdocs
cp -a          htdocs/js      %{buildroot}/%{wp_destdir}/htdocs
cp -a          htdocs/images  %{buildroot}/%{wp_destdir}/htdocs
cp -a          htdocs/vendor  %{buildroot}/%{wp_destdir}/htdocs
install -m 644 lang/*         %{buildroot}/%{wp_destdir}/lang
install -m 644 lib/*          %{buildroot}/%{wp_destdir}/lib
install -m 644 templates/*    %{buildroot}/%{wp_destdir}/templates
cp -a          vendor/*       %{buildroot}/%{wp_destdir}/vendor

## Apache configuration
mkdir -p %{buildroot}/%{_sysconfdir}/httpd/conf.d
install -m 644 %{SOURCE1} \
  %{buildroot}/%{_sysconfdir}/httpd/conf.d/white-pages.conf

# Adapt Smarty paths
sed -i \
  -e 's:/usr/share/php/smarty3:/usr/share/php/Smarty:' \
  -e 's:^#$smarty_cache_dir.*:$smarty_cache_dir = "'%{wp_cachedir}/cache'";:' \
  -e 's:^#$smarty_compile_dir.*:$smarty_compile_dir = "'%{wp_cachedir}/templates_c'";:' \
  conf/config.inc.php

# Move conf file to %%_sysconfdir
mkdir -p %{buildroot}/%{_sysconfdir}/%{name}
install -p -m 644 conf/config.inc.php \
  %{buildroot}/%{_sysconfdir}/%{name}/

# Load configuration files from /etc/white-pages/
for file in $( grep -r -l -E "\([^(]+\/conf\/[^)]+\)" %{buildroot}/%{wp_destdir} ) ; do
  sed -i -e \
    's#([^(]\+/conf/\([^")]\+\)")#("%{_sysconfdir}/%{name}/\1")#' \
    ${file}
done

%pre
# Backup old configuration to /etc/white-pages
for file in $( find %{wp_destdir}/conf -name "*.php" -type f ! -name 'config.inc.php' -printf "%f\n" 2>/dev/null );
do
    # move conf file to /etc/white-pages/*.save
    mkdir -p %{_sysconfdir}/%{name}
    mv %{wp_destdir}/conf/${file} %{_sysconfdir}/%{name}/${file}.save
done
# Move specific file config.inc.php to /etc/white-pages/config.inc.php.bak
if [[ -f "%{wp_destdir}/conf/config.inc.php"  ]]; then
    mkdir -p %{_sysconfdir}/%{name}
    mv %{wp_destdir}/conf/config.inc.php \
       %{_sysconfdir}/%{name}/config.inc.php.bak
fi


%post
# Move old configuration to /etc/self-service-password
for file in $( find %{_sysconfdir}/%{name} -name "*.save" -type f );
do
    # move previously created *.save file into its equivalent without .save
    mv ${file} ${file%.save}
done
# Clean cache
rm -rf %{wp_cachedir}/{cache,templates_c}/*


%files
%license LICENSE
%doc AUTHORS README.md
%dir %{_sysconfdir}/%{name}
%config %{_sysconfdir}/%{name}/config.inc.php
%config(noreplace) %{_sysconfdir}/httpd/conf.d/white-pages.conf
%{wp_destdir}
%dir %{wp_cachedir}
%attr(-,apache,apache) %{wp_cachedir}/cache
%attr(-,apache,apache) %{wp_cachedir}/templates_c

%changelog
* Tue Jul 01 2025 - Clement Oudot <clem@ltb-project.org> - 0.5^20250107-1
- WIP, insert changelog here
* Wed May 17 2023 - Clement Oudot <clem@ltb-project.org> - 0.4-2
- gh#126: Missing bin/ directory in packages
* Thu May 04 2023 - Clement Oudot <clem@ltb-project.org> - 0.4-1
- gh#75: Display account : empty result
- gh#76: add a option to change timeout of ldap connexion
- gh#77: Gallery by group
- gh#79: Add gallery by group
- gh#80: Add possibility to use gravatar as photo
- gh#81: Disable PHP errors (error_reporting) if debug is not set
- gh#82: Disable error reporting if debug is false
- gh#84: Manage "bytes" attributes
- gh#85: New type "bytes"
- gh#87: Possibility to negates value in search
- gh#88: Move documentation in sources
- gh#89: Add ldap_network_timeout option
- gh#92: Allow the Smarty path to be set in conf.inc.local.php
- gh#93: Configure cache dir and template cache dir
- gh#95: feat(docker): sample docker image & kubernetes deployment
- gh#97: Groups Vcard
- gh#98: Patch datepicker lang
- gh#104: Fix undefined warnings
- gh#106: Issue 88 & Small Fixes
- gh#107: Fixes on online doc
- gh#108: Bad value displayed when attribute type is a list
- gh#109: Backup files are loaded as config in lang/
- gh#110: Restrict languages to php files
- gh#112: Display list value
- gh#113: Manage cache dirs
- gh#115: WP incompatible with PHP 8+ (ldap_sort)
- gh#116: Split debug and debug_smarty
- gh#117: Provide CSS map files for minified version
- gh#118: New feature: Map
- gh#119: Use LTB LDAP common lib
- gh#120: Factorize search
- gh#121: Displayer for address
- gh#122: Address displayer (issue #121)
- gh#123: Smarty debug (issue #116)
- gh#124: Bug in group display in user and group base are the same
- gh#125: Group rendering
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
