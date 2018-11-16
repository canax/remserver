Anax remserver
==================================

[![Latest Stable Version](https://poser.pugx.org/anax/remserver/v/stable)](https://packagist.org/packages/anax/remserver)
[![Join the chat at https://gitter.im/canax/remserver](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/canax/remserver/?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

[![Build Status](https://travis-ci.org/canax/remserver.svg?branch=master)](https://travis-ci.org/canax/remserver)
[![CircleCI](https://circleci.com/gh/canax/remserver.svg?style=svg)](https://circleci.com/gh/canax/remserver)

[![Build Status](https://scrutinizer-ci.com/g/canax/remserver/badges/build.png?b=master)](https://scrutinizer-ci.com/g/canax/remserver/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/canax/remserver/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/canax/remserver/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/canax/remserver/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/canax/remserver/?branch=master)

[![Maintainability](https://api.codeclimate.com/v1/badges/47f7756bad18e2afbd71/maintainability)](https://codeclimate.com/github/canax/remserver/maintainability)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/2ee155e2516f42f3b76533bc667b6d01)](https://www.codacy.com/app/mosbth/remserver?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=canax/remserver&amp;utm_campaign=Badge_Grade)

Anax remserver module implementing a REM server. Use this module together with an Anax installation to enable a scaffolded REM server, useful for prototyping.

This REM server can be used to try out HTTP methods for GET, PUT, POST and DELETE to use CRUD operations on predefined datasets. The modified data is stored in the session.



Install and setup Anax 
------------------------------------

Proceed to the next section if you already have an installation of Anax.

You need a Anax installation, before you can use this module. You can create a sample Anax installation like this, using the scaffolding utility [`anax-cli`](https://github.com/canax/anax-cli).

Scaffold a sample Anax installation `anax-site-develop` into directory `rem`.

```
$ anax create rem anax-site-develop
$ cd rem
```

Point your webserver to `rem/htdocs` and Anax should display a Home-page.



Install REM server as part of Anax
------------------------------------

Install using composer and then integrate the module with your Anax installation.



### Install with composer

We install the REM server as a module from Packagist.

```
composer require anax/remserver
```



### Configuration files for REM server

We need to copy the configuration files for the REM server.

```
rsync -av vendor/anax/remserver/config/remserver* config
```



### API documentation

We copy the API documentation for the REM server.

```
rsync -av vendor/anax/remserver/content/index.md content/remserver.md
```

The API documentation is now available through the route `remserver`.



### Router files

```
rsync -av vendor/anax/remserver/config/route/remserver.php config/route
```

You need to include the router file in your router configuration `config/route.php`. There is a sample you can use in `vendor/anax/remserver/config/route.php`.



### DI services

You need to add the configuration for the di services `config/di.php`. There is a sample you can use in `vendor/anax/remserver/config/di.php`.



License
------------------------------------

This software carries a MIT license.



```
 .  
..:  Copyright (c) 2017 - 2018 Mikael Roos (mos@dbwebb.se)
```
