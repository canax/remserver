#!/usr/bin/env bash
#
# Install REM Server into an Anax installation using a default setup.
#
install -d config/di config/route
rsync -av vendor/anax/remserver/config/remserver* config
rsync -av vendor/anax/remserver/content/index.md content/remserver.md
rsync -av vendor/anax/remserver/config/route/remserver.php config/route
rsync -av vendor/anax/remserver/config/di.php config/di
