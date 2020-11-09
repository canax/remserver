Anax REM server (anax/remserver)
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

Anax REM server (remserver) module implements a REM server. A REM server is a REST Mockup API, useful for development and test of REST clients.

You can use this module, together with an Anax installation, to enable a quickly scaffolded REM server, useful for test, development and prototyping.

This remserver can be used with various HTTP methods to use CRUD operations on predefined datasets. You can add and supply your own JSON datasets which will be loaded by configuration.

The data is stored in the session and can therefore not be shared between users and browsers.



Use REM server as a web service
------------------------------------

This module is bundled together with an Anax website in the repo "[Anax REM server website](https://github.com/canax/remserver-website)" which is hosted at `https://rem.dbwebb.se`.

There you can read the documentation on how to use the REM service and try it out.



Install as an Anax module
------------------------------------

This is how you install the module into an existing Anax installation, for example an installation of `[anax/anax](https://github.com/canax/anax)`.

There are two steps in the installation procedure, 1) first install the module using composer and then 2) integrate it into you Anax base installation.



### Step 1, install using composer.

Install the module using composer.

```
composer require anax/remserver
```



### Step 2, integrate into your Anax base

You can review the module configuration file in the directory `vendor/anax/remserver/config`. It consists of the following parts.

| File | Description |
|------|-------------|
| `di/remserver.php` | Add "remserver" as a di service to make it easy to use from the controller, this is implemented by the model class `RemServer`. |
| `remserver/dataset` | These datasets are loaded upon start, when the "remserver" gets activated as a di service. You may add your own dataset to extend the server. |
| `remserver/config.php` | The configuration file read by the di service "remserver" when it is activated. Here you decide what datasets to load into. |
| `remserver/README.md` | Short explanation on how to add new datasets. |
| `router/700_remserver.php` | The routes supported for the REM server API. All routes are implemented by the `RemServerController` class.

You may copy all the module configuration files with the following command.

```
# Go to the root of your Anax base repo
rsync -av vendor/anax/remserver/config ./
```

The remserver is now active on the route `remserver/`. You may try it out on the route `remserver/users` to get the default dataset `users`.

Optionally you may copy the API documentation as Markdown content. Do this only if you have support for Flat File Content from the `content/` directory.

```
rsync -av vendor/anax/remserver/content/index.md content/remserver-api.md
```

The API documentation is now available through the route `remserver-api`.

You can now use the REM server module as an integrated part of you Anax installation.



Dependency
------------------

This is a Anax modulen and its usage is primarly intended to be together with the Anax framework.

You can install an instance on [anax/anax](https://github.com/canax/anax) and run this module inside it, to try it out for test and development.

The repo "[Anax REM server website](https://github.com/canax/remserver-website)" is an example of how that can be done.
