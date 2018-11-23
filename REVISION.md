Revision history
=================================



v2.1.0 (2018-11-23)
---------------------------------

* Rewrote controller with router specific paths matching controller methods.
* Updated testbase to reflect changes.



v2.0.1 (2018-11-23)
---------------------------------

* Fix travis build and add PHP7.3.



v2.0.0 (2018-11-22)
---------------------------------

* Add codacy badge.
* Removed Sensiolabs as validation tool.
* Upgrade to PHP 7.2.
* Use anax/anax-lite as base.
* No need to setup remserver in $di, as a controller.
* Rearrange the configuration files and store all in config/remserver.
* Refactor controller to work with new controller layout using catchAll().
* Rewrote testcases.



v1.1.0 (2018-03-08)
---------------------------------

* Move to CircleCI 2.0.
* Move Travis to PHP 7.0 an up.
* Move composer.json to require PHP 7.0.
* Update Makefile with Docker and flexible install av PHPUnit.
* Move PHPUnit test to PHP 7.0 and above.
* Add docker support through docker-compose.yaml.
* Fix Scrutinizer to install phpunit.



v1.0.5 (2018-03-08)
---------------------------------

* Add instructions to README on how to setup an Anax installation from scratch.



v1.0.4 (2017-10-15)
---------------------------------

* Add phpunit/phpunit to composer.json dev for Scrutinizer.
* Make 100% unit tests.



v1.0.3 (2017-10-02)
---------------------------------

* Added unittests for RemServer.
* Adding scripts to ease test and development.
* Add badge and configuration for CodeClimate.
* Fix code quality according to scrutinizer.
* Rewrite duplicate code in RemServer.
* Fix testcase using session as array.
* Enhance makefile to read proper exit status from piped command.
* Enhance ruleset for phpmd.
* Add phpcpd to makefile and testsuite.



v1.0.2 (2017-09-27)
---------------------------------

* Integrate with travis, circleci, scrutinizer and sensiolabsinsight.



v1.0.1 (2017-09-26)
---------------------------------

* Add testcases for phpunit.



v1.0.0 (2017-09-25)
---------------------------------

* First version.
