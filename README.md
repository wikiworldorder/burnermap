
# WikiWorldOrder/BurnerMap

[![Laravel](https://img.shields.io/badge/Laravel-5.6-orange.svg?style=flat-square)](http://laravel.com)
[![License](http://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://tldrlegal.com/license/mit-license)

<a href="https://github.com/wikiworldorder/burnermap" target="_blank">BurnerMap</a>, atop 
<a href="https://laravel.com/" target="_blank">Laravel</a>. 

# Table of Contents
* [Requirements](#requirements)
* [Getting Started](#getting-started)
* [Documentation](#documentation)
* [Roadmap](#roadmap)
* [Change Logs](#change-logs)
* [Contribution Guidelines](#contribution-guidelines)
* [Reporting a Security Vulnerability](#security-help)


# <a name="requirements"></a>Requirements

* php: >=7.1.*
* <a href="https://packagist.org/packages/laravel/framework" target="_blank">laravel/framework</a>: 5.6.*
* <a href="https://packagist.org/packages/laravel/socialite" target="_blank">laravel/socialite</a>: 3.*

# <a name="getting-started"></a>Getting Started

Here are instructions if you are new to Laravel, or just want step-by-step instructions on how to install its 
development environment, Homestead: 
<a href="https://survloop.org/how-to-install-laravel-on-a-digital-ocean-server" 
    target="_blank">SurvLoop.org/how-to-install-laravel-on-a-digital-ocean-server/</a>.

The instructions below include the needed steps to install BurnerMap.

* Install Laravel's default user authentication:

```
$ php artisan make:auth
```

* Update `composer.json` to add a requirement for Socialite, and associate paths for BurnerMap classes:

```
$ nano composer.json
```

```
...
"require": {
	...
    "laravel/socialite": "^3.0",
    "wikiworldorder/burnermap": "0.*",
	...
},
...
"autoload": {
	...
	"psr-4": {
		...
		"BurnerMap\\": "vendor/wikiworldorder/burnermap/src/",
	}
	...
},
...
```

```
$ composer update
```

* Add the package to your application service providers in `config/app.php`.

```
$ nano config/app.php
```

```php
...
'providers' => [
	...
	BurnerMap\BurnerMapServiceProvider::class,
	...
],
...
'aliases' => [
	...
	'BurnerMap'	 => 'WikiWorldOrder\BurnerMap\BurnerMapFacade',
	...
],
...
```

* Update composer, publish the package migrations, etc...

```
$ php artisan vendor:publish --force
$ php artisan migrate
$ composer dump-autoload
$ php artisan db:seed --class=BurnerMapSeeder
```

* Download packages and copy to public folers...

<a href="https://jquery.com/download/" target="_blank">jquery.com/download/</a>
Copy the compressed, production jQuery file to your Laravel directory, eg: public/js/jquery-3.3.1.min.js

<a href="www.shadowbox-js.com/download.html" target="_blank">shadowbox-js.com/download.html</a>
Copy the Shadowbox folder to your Laravel directory: public/js/shadowbox-3.0.3

<a href="https://github.com/flot/flot" target="_blank">github.com/flot/flot</a>
Copy flot-master folder to your Laravel directory: public/js/flot-master

<a href="https://fonts.google.com/specimen/Oswald" target="_blank">fonts.google.com/specimen/Oswald</a>
Copy folder with TTF files to your Laravel directory: public/css/Oswald

* Change permissions so admins can upload new maps...

```
$ chown -R www-data:33 public/images
```

# <a name="documentation"></a>Documentation

Most of the core BurnerMap action is controlled by /src/Controllers/BurnerMap.php and /src/Views/.
The Facebook connection is operated by Laravel's Socialite package, utilized from /src/Controllers/FaceController.php.

More documentation coming soon...

# <a name="roadmap"></a>Roadmap

I originally built BurnerMap in 2011, and not a great deal changed outside of the admin tools.
In reorganizing the code to release it open source, I primarily just converted it to run atop the Laravel framework.
I did lots of code cleanup on the PHP level, and adapted database queries to Laravel's Eloquent, 
but haven't yet made it to the Javascript, or CSS (which will be worked on alongside a big, overdue UX upgrade). 
I haven't applied everything I've learned in the past 8 years, but it's lightyears cleaner than it's been!-P

* I expect some more fixes and a few small functionality upgrades this summer.

# <a name="change-logs"></a>Change Logs


# <a name="contribution-guidelines"></a>Contribution Guidelines

Please help educate me on best practices for sharing code in this community.
Please report any issue you find in the issues page.

# <a name="security-help"></a>Reporting a Security Vulnerability

We want to ensure that SurvLoop is a secure HTTP open data platform for everyone. 
If you've discovered a security vulnerability in SurvLoop, 
we appreciate your help in disclosing it to us in a responsible manner.

Publicly disclosing a vulnerability can put the entire community at risk. 
If you've discovered a security concern, please email us at wikiworldorder *at* protonmail.com. 
We'll work with you to make sure that we understand the scope of the issue, and that we fully address your concern. 
We consider correspondence sent to wikiworldorder *at* protonmail.com our highest priority, 
and work to address any issues that arise as quickly as possible.

After a security vulnerability has been corrected, a release will be deployed as soon as possible.
