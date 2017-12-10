<p align="center">
    <img src="https://avatars0.githubusercontent.com/u/25637657?s=200&v=4">
</p>

> A GitLab bot enforcing code review of each Merge Request.

[![Build Status](https://travis-ci.org/OsLab/cibot.svg?branch=master)](https://travis-ci.org/OsLab/cibot)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/OsLab/cibot/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/OsLab/cibot/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/OsLab/cibot/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/OsLab/cibot/?branch=master)
[![Total Downloads](https://poser.pugx.org/OsLab/cibot/downloads)](https://packagist.org/packages/OsLab/cibot)
[![Latest Stable Version](https://poser.pugx.org/OsLab/cibot/v/stable)](https://packagist.org/packages/OsLab/cibot)
[![License](https://poser.pugx.org/OsLab/cibot/license)](https://packagist.org/packages/oslab/cibot)

Introduction
-------------
This bot has for objective to give labels to merge request, to merge when the number of votes is reached and when the requirements on acquired. (approved build, approved by owner or members..)

> :warning: This project is in state W.I.P (Work In Progress).

> Your contributions are welcome.

Installation
------------

    $ composer install
    $ php bin/console doctrine:database:create
    $ php bin/console doctrine:schema:update --force

## Credits

* [All contributors](https://github.com/OsLab/cibot/graphs/contributors)

## License

Security API bundle is released under the MIT License, you agree to license your code under the [MIT license](LICENSE)
