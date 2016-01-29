## Laravel database settings

![][maintainedstatus-img] [![License][license-img]][license-url] [![Total Downloads] [downloads-img]][downloads-url]

> Store special settings, configs to database. No replace normal laravel config usage, only alternative for site settings.

----------

### Installation

To add juy/setting to your Laravel application, follow these steps:

Add the following to your `composer.json` file:

```json
"juy/setting": "dev-master"
```

Then, run `composer update` or `composer install` if you have not already installed packages.

Add the below line to the `providers` array in `app/config/app.php` configuration file (*Need to add to the beginning/top, otherwise you may receive an error when you use the any config file*).

```php
'Juy\Setting\SettingServiceProvider',
```

### Usage

```php
// Get single value
Setting::get('mail_driver');

// Get single value with default value
Setting::get('mail_driver', 'default value');

// Set single value
Setting::set('mail_driver', 'smtp');

// Set multiple key, value
Setting::insert([$key => $value]);

// Set key, value from form post data
$post = Input::except('_token'); // except for token
Setting::insert($post);
```

### Migration

```shell
php artisan migrate --package=juy/setting
```

### Seed

There is no seed file, create one as you want.

```php
<?php

use Juy\Setting\Model\Setting;

class SettingsTableSeeder extends \Seeder {

	public function run()
	{
		DB::table('settings')->truncate();

		Setting::insert([
			[
				'key'	=> 'mail_driver',
				'value'	=> 'smtp'
			],
			[
				'key'	=> 'mail_host',
				'value'	=> 'smtp.mailgun.org'
			],
		]);

	}
}
```

### License

This project is open-sourced software licensed under the [MIT license][mit-url].



[maintainedstatus-img]: http://img.shields.io/badge/project-maintained-brightgreen.svg?style=flat-square

[license-img]: https://img.shields.io/packagist/l/juy/setting.svg?style=flat-square
[license-url]: https://packagist.org/packages/juy/setting
[downloads-img]: https://img.shields.io/packagist/dt/juy/setting.svg?style=flat-square
[downloads-url]: https://packagist.org/packages/juy/setting

[mit-url]: http://opensource.org/licenses/MIT
