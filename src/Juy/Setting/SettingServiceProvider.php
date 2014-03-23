<?php namespace Juy\Setting;

use Illuminate\Support\ServiceProvider;
//use Illuminate\Foundation\AliasLoader;

class SettingServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('juy/setting');
	}
	
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['setting'] = $this->app->share(function($app)
		{
			return new Setting;
		});

		/*
		// Auto alias
		$this->app->booting(function()
		{
			$loader = AliasLoader::getInstance();
			$loader->alias('Setting', 'Juy\Setting\Facades\Setting');
		});
		*/
	}
	
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('setting');
    }

}
