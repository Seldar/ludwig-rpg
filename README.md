Ludwig-rpg Application[![Build Status](https://travis-ci.org/Seldar/ludwig-rpg.svg?branch=master)](https://travis-ci.org/Seldar/ludwig-rpg) [![codecov.io](http://codecov.io/github/Seldar/ludwig-rpg/coverage.svg?branch=master)](http://codecov.io/github/Seldar/ludwig-rpg?branch=master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Seldar/ludwig-rpg/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Seldar/ludwig-rpg/?branch=master)
=====================

The "Ludwig-rpg Application" is a mud-like game that provides a simple command line tool to create a character named ludwig, who could explore and challenge other developers to earn experience and ultimately become a guru developer.   

Features
------------
  * Create your character by choosing a class and distribute your starting freebies to attributes that matter!
  * Explore the interwebz and find famous challengers to improve yourself!
  * Level up all the way to Software Guru and become the ultimate coder!
  * Check your attributes and level anytime!
  * Save your progress anytime and get a save-key which you can use later to load your game! 

Requirements
------------

  * PHP 5.6 or higher;
  * [PHPUnit ^5.6](https://github.com/sebastianbergmann/phpunit)
  * [DbUnit ^1.2](https://github.com/sebastianbergmann/dbunit)
  * [Sqlite3 extension](https://secure.php.net/manual/en/sqlite3.installation.php) 
  

Installation
------------


Install using composer:

```bash
$ composer install
```

Usage
-----

Run the command line tool to start a new game:

```bash
$ php ludwig.php
```

If you want to load a previous game use this command:

```bash
$ php ludwig.php resume 'YOUR-SAVE-KEY'
```

