# Laravel database settings
[![Still Maintained][stillmaintained-img]][stillmaintained-url] [![Tag][tag-img]][tag-url] [![License][license-img]][license-url] [![Total Downloads] [downloads-img]][downloads-url]

> Store special settings, configs to database. No replace normal laravel config usage, only alternative for site settings.

## Help support this project
If you'd like to support this and other our creations projects, donate via [PayPal][paypal-donate-url].

[![Support via PayPal][paypal-donate-img]][paypal-donate-url]

----------
## Installation
To add juy/setting to your Laravel application, follow these steps:

Add the following to your `composer.json` file:

```json
"juy/setting" : "dev-master"
```

Then, run `composer update` or `composer install` if you have not already installed packages.

Add the below line to the `providers` array in `app/config/app.php` configuration file (*Need to add to the beginning/top, otherwise you may receive an error when you use the any config file*).

```php
'Juy\Setting\SettingServiceProvider',
```

Add the below line to the `aliases` array in `app/config/app.php` configuration file.

```php
'Setting' => 'Juy\Setting\Facades\Setting',
```
## Usage

```php
// Get single value
Setting::get('mail_driver');

// Set single value
Setting::set('mail_driver', 'smtp');

// Set multiple key, value
Setting::insert(array($key => $value));

// Set key, value from form post data
$post = Input::except('_token'); // except for token
Setting::insert($post);
```

## Migration
```shell
php artisan migrate --package=juy/setting
```

## Seed
There is no seed file, create one as you want.

```php
<?php

use Juy\Setting\Model\Setting;

class SettingsTableSeeder extends \Seeder {

	public function run()
	{
		DB::table('settings')->truncate();

		Setting::insert(array(
			// Mail
			array(
				'key'	=> 'mail_driver',
				'value'	=> 'smtp'
			),
			array(
				'key'	=> 'mail_host',
				'value'	=> 'smtp.mailgun.org'
			),
			array(
				'key'	=> 'mail_port',
				'value'	=> '587'
			),
			array(
				'key'	=> 'mail_encrypt',
				'value'	=> 'tls'
			),
			array(
				'key'	=> 'mail_smtpUser',
				'value'	=> ''
			),
			array(
				'key'	=> 'mail_smtpPass',
				'value'	=> ''
			)
		));

	}
}
```
## License
This project is open-sourced software licensed under the [MIT license][mit-url].

[stillmaintained-img]: http://img.shields.io/badge/project-maintained-brightgreen.svg?style=flat
[stillmaintained-url]: http://stillmaintained.com/juy/setting
[tag-img]: http://img.shields.io/github/tag/juy/setting.svg?style=flat
[tag-url]: https://packagist.org/packages/juy/setting
[license-img]: http://img.shields.io/packagist/l/juy/setting.svg?style=flat
[license-url]: https://packagist.org/packages/juy/setting
[downloads-img]: http://img.shields.io/packagist/dt/juy/setting.svg?style=flat
[downloads-url]: https://packagist.org/packages/juy/setting

[paypal-donate-img]: http://img.shields.io/badge/PayPal-donate-brightgreen.svg?style=flat
[paypal-donate-url]: http://bit.ly/donateAngelside

[mit-url]: http://opensource.org/licenses/MIT
