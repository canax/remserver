#!/usr/bin/env bash
#
# anax/remserver
#
# Integrate the REM server onto an existing anax installation.
#

# Copy the configuration files
rsync -av vendor/anax/remserver/config ./

# Copy the documentation
install -d content/doc
rsync -av vendor/anax/remserver/content/index.md ./content/doc/remserver.md
