#!/bin/sh

# Make tar.gz distribution of White Pages
# Usage:
# * Run from current directory
# * Set version as parameter
# Example:
# ./makedist.sh 0.4

# Get version
VERSION=$1

# Program name
NAME=ltb-project-white-pages

# Remove previous packages if any
rm -f $NAME*

# Create dist dir
mkdir -p $NAME-$VERSION
mkdir -p $NAME-$VERSION/cache
mkdir -p $NAME-$VERSION/conf
mkdir -p $NAME-$VERSION/htdocs
mkdir -p $NAME-$VERSION/lang
mkdir -p $NAME-$VERSION/lib
mkdir -p $NAME-$VERSION/templates
mkdir -p $NAME-$VERSION/templates_c

# Copy files
cp    ../AUTHORS     $NAME-$VERSION
cp    ../LICENCE     $NAME-$VERSION
cp    ../README.md   $NAME-$VERSION
cp -a ../conf/*      $NAME-$VERSION/conf
cp -a ../htdocs/*    $NAME-$VERSION/htdocs
cp -a ../lang/*      $NAME-$VERSION/lang
cp -a ../lib/*       $NAME-$VERSION/lib
cp -a ../templates/* $NAME-$VERSION/templates

# Create archive
tar -cf $NAME-$VERSION.tar $NAME-$VERSION/

# Compress
gzip $NAME-$VERSION.tar

# Remove dist dir
rm -rf $NAME-$VERSION

# I am proud to tell you that I finished the job
echo "Archive build: $NAME-$VERSION"

# Exit
exit 0
