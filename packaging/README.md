# Some notes on packaging White Pages

## Version update

Update version in following files:

* htdocs/index.php
* packaging/rpm/SPECS/white-pages.spec
* packaging/debian/changelog

## Update dependencies and run tests

From the white-pages root directory, run:

```
composer update
```

Run tests:

```
XDEBUG_MODE=coverage vendor/bin/phpunit --coverage-text --configuration tests/phpunit.xml
```

After the tests, remove the useless dependencies:

```
composer update --no-dev
```

## Archive tar.gz

From current directory, do:
```
$ ./makedist VERSION
```

with VERSION the current verion of the package

For example:
```
$ ./makedist 0.4
```

## Debian

Form current directory, do:
```
$ dpkg-buildpackage -b -kLTB
```

If you do not have LTB GPG secret key, do:
```
$ dpkg-buildpackage -b -us -uc
```

# 2 - RPM (RHEL, CentOS, Fedora, ...)

Prepare your build environment, for example in /home/clement/build.
You should have a ~/.rpmmacros like this:

```
%_topdir /home/clement/build
%dist .el5
%distribution .el5
%_signature gpg
%_gpg_name 6D45BFC5
%_gpgbin /usr/bin/gpg
%packager Clement OUDOT <clem.oudot@gmail.com>
%vendor LTB-project
```

Copy packaging files from current directory to build directory:
```
$ cp -Ra rpm/* /home/clement/build
```

Copy archive to SOURCES/:
```
$ cp ltb-project-white-pages-VERSION.tar.gz /home/clement/build/SOURCES
```

Go in build directory and build package:
```
$ cd /home/clement/build
$ rpmbuild -ba SPECS/white-pages.spec
```

Sign RPM:
```
$ rpm --addsign RPMS/noarch/white-pages*
```

## Docker

Pre-requisites:

* docker / podman
* if docker: a version with buildkit (included by default in Docker Engine
  as of version 23.0, but can be enabled in previous versions with
  DOCKER_BUILDKIT=1 in build command line)

From "packaging" directory, do:

``` 
DOCKER_BUILDKIT=1 docker build -t white-pages -f ./docker/Dockerfile ../
```

You can also build with podman:

```
podman build --no-cache -t white-pages -f ./docker/Dockerfile ../
```

For Alpine linux image :

```
DOCKER_BUILDKIT=1 docker build -t white-pages-alpine -f ./docker/Dockerfile.alpine ../
```

Tag the defautl and alpine images with the major and minor version, for example:

```
docker tag white-pages:latest ltbproject/white-pages:0.5.1
docker tag white-pages:latest ltbproject/white-pages:0.5
docker tag white-pages:latest ltbproject/white-pages:latest
docker tag white-pages-alpine:latest ltbproject/white-pages:alpine-0.5.1
docker tag white-pages-alpine:latest ltbproject/white-pages:alpine-0.5
docker tag white-pages-alpine:latest ltbproject/white-pages:alpine-latest
