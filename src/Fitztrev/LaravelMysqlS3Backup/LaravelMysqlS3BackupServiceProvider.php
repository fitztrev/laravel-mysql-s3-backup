<?php namespace Fitztrev\LaravelMysqlS3Backup;

use Illuminate\Support\ServiceProvider;

class LaravelMysqlS3BackupServiceProvider extends ServiceProvider {

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
		$this->package('fitztrev/laravel-mysql-s3-backup');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['fitztrev/laravel-mysql-s3-backup'] = $this->app->share(function(){
			return new Commands\MysqlS3Backup();
		});
		$this->commands([
			'fitztrev/laravel-mysql-s3-backup'
		]);
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
