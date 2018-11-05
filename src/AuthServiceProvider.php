<?php

namespace Cdz\Auth;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Cdz\Auth\Console\AuthInstall;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    	$this->schemaDefaultStringLength();
    }
	
	/**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    	$this->registerCommands();
    }
	
	
	/**
	 * Schema default string length bugfix
	 * 
	 * @return void
	 */
	 protected function schemaDefaultStringLength() {
	 	Schema::defaultStringLength(191);
	 }
	
	/**
     * Register the commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        $this->commands([
            AuthInstall::class
        ]);
    }
	
	/**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            AuthInstall::class
        ];
    }

    
}
