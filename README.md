Anax REM server (remserver)
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

You can use this module, together with an Anax installation, to enable a scaffolded REM server, useful for test, development and prototyping.

This remserver can be used with various HTTP methods to use CRUD operations on predefined datasets.

The data is stored in the session and can therefore not be shared between users and browsers.



Table of content
------------------------------------

* [Install as Anax module](#Install-as-Anax-module)
* [Install using scaffold postprocessing file](#Install-using-scaffold-postprocessing-file)
* [Install and setup Anax](#Install-and-setup-Anax)
* [Dependency](#Dependency)
* [License](#License)

You can also read this [documentation online](https://canax.github.io/remserver/).



Install as Anax module
------------------------------------

This is how you install the module into an existing Anax installation.

Install using composer.

```
composer require anax/remserver
```

Copy the needed configuration and setup the remserver as a route handler for the route `remserver`.

```
rsync -av vendor/anax/remserver/config ./
```

The remserver is now active on the route `remserver/` according to the API documentation. You may try it out on the route `remserver/users` to get the default dataset `users`. 

Optionally you may copy the API documentation.

```
rsync -av vendor/anax/remserver/content/index.md content/remserver-api.md
```

The API documentation is now available through the route `remserver-api`.



Install using scaffold postprocessing file
------------------------------------

The module supports a postprocessing installation script, to be used with Anax scaffolding. The script executes the default installation, as outlined above.

```text
bash vendor/anax/remserver/.anax/scaffold/postprocess.d/700_remserver.bash
```

The postprocessing script should be run after the `composer require` is done.



Install and setup Anax 
------------------------------------

You need a Anax installation, before you can use this module. You can create a sample Anax installation, using the scaffolding utility [`anax-cli`](https://github.com/canax/anax-cli).

Scaffold a sample Anax installation `anax-site-develop` into the directory `rem`.

```
$ anax create rem anax-site-develop
$ cd rem
```

Point your webserver to `rem/htdocs` and Anax should display a Home-page.



Dependency
------------------

This is a Anax modulen and primarly intended to be used together with the Anax framework.



License
------------------

This software carries a MIT license. See [LICENSE.txt](LICENSE.txt) for details.



```
 .  
..:  Copyright (c) 2017 - 2019 Mikael Roos (mos@dbwebb.se)
```
