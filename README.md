Developed for private/special use. If used, no support and no responsibility.

## config/app.php additions ##

### Provider ###
need to add to the beginning/top.

    'Juy\Setting\SettingServiceProvider'

### Alias ###

    'Setting' => 'Juy\Setting\Facades\Setting'

## Usage ##

    Setting::get('mail.driver');

    Setting::set('mail.driver');

    Setting::insert($data = array());

## Migration ##

    ...