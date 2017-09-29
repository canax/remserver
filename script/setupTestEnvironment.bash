#!/usr/bin/env bash
#
# Setup a test environment for the module.
#

#
# Exit with an error message
# $1 the message to display
# $2 an optinal exit code, default is 1
#
function error_exit {
    echo "$1" >&2
    exit "${2:-1}"
}

# Check Makefile is available and we are in the root of the repo
[ ! -f Makefiles ] || \
    error_exit "Missing file 'Makefile', are you really executing this script from the root of the repo?"

# Prepare directory structure where to place installation
make prepare
cd build || \
    error_exit "Missing directory 'build'"

# Scaffold a anax development installation
anax create anax anax-site-develop
cd anax || \
    error_exit "Dir for anax installation was not created."

composer require anax/remserver
pwd
ls
#vendor/anax/remserver/script/installDefault.bash

echo "The testinstallation is in build/anax."
echo "Point your browser to build/anax/htdocs."
