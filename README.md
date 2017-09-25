Anax remserver
==================================

[![Latest Stable Version](https://poser.pugx.org/anax/remserver/v/stable)](https://packagist.org/packages/anax/remserver)
[![Join the chat at https://gitter.im/mosbth/anax](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/canax?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![Build Status](https://travis-ci.org/canax/remserver.svg?branch=master)](https://travis-ci.org/canax/remserver)
[![CircleCI](https://circleci.com/gh/canax/remserver.svg?style=svg)](https://circleci.com/gh/canax/remserver)
[![Build Status](https://scrutinizer-ci.com/g/canax/remserver/badges/build.png?b=master)](https://scrutinizer-ci.com/g/canax/remserver/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/canax/remserver/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/canax/remserver/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/canax/remserver/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/canax/remserver/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/d831fd4c-b7c6-4ff0-9a83-102440af8929/mini.png)](https://insight.sensiolabs.com/projects/d831fd4c-b7c6-4ff0-9a83-102440af8929)

Anax remserver module implementing a REM server.



Install
------------------

Install using composer and then integrate the module with your Anax installation.



### Install with composer

```
composer require anax/remserver
```



### Configuration files for REM server

```
rsync -av vendor/anax/remserver/config/remserver* config
```



### API documentation

```
rsync -av vendor/anax/remserver/content/index.md content/remserver.md
```

THe API documentation is now available through the route `remserver`.



### Router files

```
rsync -av vendor/anax/remserver/config/route/remserver.php config/route
```

You need to include the router file in your router configuration `config/route.php`. There is a sample you can use in `venor/anax/remserver/config/route.php`.



### DI services

You need to add the services di configuration `config/di.php`. There is a sample you can use in `venor/anax/remserver/config/di.php`.



License
------------------

This software carries a MIT license.



```
 .  
..:  Copyright (c) 2017 Mikael Roos (mos@dbwebb.se)
```
