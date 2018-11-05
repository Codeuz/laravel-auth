<?php

namespace Cdz\Auth\Console;

use Illuminate\Console\Command;
use Illuminate\Console\DetectsApplicationNamespace;

class AuthInstall extends Command {
	
	 use DetectsApplicationNamespace;

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $signature = 'cdz-auth:install
						{--views : Only scaffold the views}
						{--force : Overwrite existing views by default}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command to scaffold all of the files required for authentication.';
	
	/**
     * The views that need to be exported.
     *
     * @var array
     */
    protected $views = [
        'layouts/app.stub' => 'layouts/app.blade.php',
        'layouts/logged.stub' => 'layouts/logged.blade.php',
        'layouts/unlogged.stub' => 'layouts/unlogged.blade.php',
        'logged/dashboard.stub' => 'logged/dashboard.blade.php',
        'unlogged/home.stub' => 'unlogged/home.blade.php',
        'auth/passwords/email.stub' => 'auth/passwords/email.blade.php',
        'auth/passwords/reset.stub' => 'auth/passwords/reset.blade.php',
        'auth/login.stub' => 'auth/login.blade.php',
        'auth/register.stub' => 'auth/register.blade.php',
        'auth/verify.stub' => 'auth/verify.blade.php',
        'vendor/mail/html/message.stub' => 'vendor/mail/html/message.blade.php',
        'vendor/mail/markdown/message.stub' => 'vendor/mail/markdown/message.blade.php',
        'vendor/notifications/email.stub' => 'vendor/notifications/email.blade.php'
    ];
	
	/**
     * The translations that need to be exported.
     *
     * @var array
     */
    protected $translations = [
        'en/auth.stub' => 'en/auth.php',
        'en/layout.stub' => 'en/layout.php',
        'en/pagination.stub' => 'en/pagination.php',
        'en/passwords.stub' => 'en/passwords.php',
        'en/validation.stub' => 'en/validation.php',
        'en/messages.stub' => 'en/messages.php',
        'fr/auth.stub' => 'fr/auth.php',
        'fr/layout.stub' => 'fr/layout.php',
        'fr/pagination.stub' => 'fr/pagination.php',
        'fr/passwords.stub' => 'fr/passwords.php',
        'fr/validation.stub' => 'fr/validation.php',
        'fr/messages.stub' => 'fr/messages.php'
    ];
	
	/**
     * The controllers that need to be exported.
     *
     * @var array
     */
	protected $controllers = [
		'/stubs/install/controllers/Logged/DashboardController.stub' => 'Http/Controllers/Logged/DashboardController.php',
		'/stubs/install/controllers/UnLogged/HomeController.stub' => 'Http/Controllers/UnLogged/HomeController.php',
		'/stubs/install/controllers/Auth/LoginController.stub' => 'Http/Controllers/Auth/LoginController.php',
		'/stubs/install/controllers/Auth/RegisterController.stub' => 'Http/Controllers/Auth/RegisterController.php',
		'/stubs/install/controllers/Auth/ResetPasswordController.stub' => 'Http/Controllers/Auth/ResetPasswordController.php',
		'/stubs/install/controllers/Auth/VerificationController.stub' => 'Http/Controllers/Auth/VerificationController.php'
	];
	
	/**
     * The middlewares that need to be exported.
     *
     * @var array
     */
     protected $middlewares = [
     	'/stubs/install/middleware/Authenticate.stub' => 'Http/Middleware/Authenticate.php',
     	'/stubs/install/middleware/RedirectIfAuthenticated.stub' => 'Http/Middleware/RedirectIfAuthenticated.php',
     ];
	 
	 /**
     * The notifications that need to be exported.
     *
     * @var array
     */
     protected $notifications = [
     	'/stubs/install/notifications/ResetPassword.stub' => 'Notifications/ResetPassword.php',
     	'/stubs/install/notifications/VerifyEmail.stub' => 'Notifications/VerifyEmail.php',
     ];

	/**
     * Execute the command.
     */
    public function handle()
	{
		$this->createDirectories();
		
		$this->exportViews();
		
		$this->exportTranslations();
		
		$this->exportAssets();
		
		if (! $this->option('views')) {
			
			$this->exportControllers();
			$this->exportMiddlewares();
			$this->exportNotifications();
			
			file_put_contents(
                app_path('User.php'),
                $this->compileControllerStub('/stubs/install/User.stub', true)
            );
			
			file_put_contents(
                base_path('database/migrations/2018_10_30_112552_update_users_table.php'),
                file_get_contents(__DIR__.'/stubs/install/migrations/2018_10_30_112552_update_users_table.stub')
            );

            file_put_contents(
                base_path('routes/web.php'),
                file_get_contents(__DIR__.'/stubs/install/routes.stub'),
                FILE_APPEND
            );
			
			
        }
		
		$this->info('Auth scaffold generated successfully.');
	}

	
	/**
     * Create the directories for the files.
     *
     * @return void
     */
    protected function createDirectories()
    {
    	/*
		 * View directories
		 */ 
        if (! is_dir($directory = resource_path('views/layouts'))) {
            mkdir($directory, 0755, true);
        }

        if (! is_dir($directory = resource_path('views/logged'))) {
            mkdir($directory, 0755, true);
        }
		
		if (! is_dir($directory = resource_path('views/unlogged'))) {
            mkdir($directory, 0755, true);
        }
		
		if (! is_dir($directory = resource_path('views/auth'))) {
            mkdir($directory, 0755, true);
        }
		
		if (! is_dir($directory = resource_path('views/auth/passwords'))) {
            mkdir($directory, 0755, true);
        }
		
		if (! is_dir($directory = resource_path('views/vendor'))) {
            mkdir($directory, 0755, true);
        }
		
		if (! is_dir($directory = resource_path('views/vendor/mail'))) {
            mkdir($directory, 0755, true);
        }
		
		if (! is_dir($directory = resource_path('views/vendor/mail/html'))) {
            mkdir($directory, 0755, true);
        }
		
		if (! is_dir($directory = resource_path('views/vendor/mail/markdown'))) {
            mkdir($directory, 0755, true);
        }
		
		if (! is_dir($directory = resource_path('views/vendor/notifications'))) {
            mkdir($directory, 0755, true);
        }
		
		/*
		 * Translations directories
		 */ 
       	if (! is_dir($directory = resource_path('lang/fr'))) {
            mkdir($directory, 0755, true);
        }
		
		/*
		 * Controllers directories
		 */
		if (! is_dir($directory = app_path('Http/Controllers/Auth'))) {
            mkdir($directory, 0755, true);
        }
		
		if (! is_dir($directory = app_path('Http/Controllers/Logged'))) {
            mkdir($directory, 0755, true);
        }
		
		if (! is_dir($directory = app_path('Http/Controllers/UnLogged'))) {
            mkdir($directory, 0755, true);
        }
		
		/*
		 * Notifications directories
		 */
		if (! is_dir($directory = app_path('Notifications'))) {
         	mkdir($directory, 0755, true);
        }
    }
	
	/**
     * Export the views.
     *
     * @return void
     */
    protected function exportViews()
    {
        foreach ($this->views as $key => $value) {
            if (file_exists($view = resource_path('views/'.$value)) && ! $this->option('force')) {
                if (! $this->confirm("The [{$value}] view already exists. Do you want to replace it?")) {
                    continue;
                }
            }

            copy(
                __DIR__.'/stubs/install/views/'.$key,
                $view
            );
        }
    }

	/**
     * Export the translations.
     *
     * @return void
     */
    protected function exportTranslations()
    {
        foreach ($this->translations as $key => $value) {
            if (file_exists($translation = resource_path('lang/'.$value)) && ! $this->option('force')) {
                if (! $this->confirm("The [{$value}] translation file already exists. Do you want to replace it?")) {
                    continue;
                }
            }

            copy(
                __DIR__.'/stubs/install/lang/'.$key,
                $translation
            );
        }
    }
	
	/**
	 * Export assets
	 * 
	 * @return void
	 */
	 protected function exportAssets()
	 {
	 	$this->call('cdz-bootstrap:install', ['--assets' => true, '--force' => ($this->option('force') ? true : false)]);
	 }
	 
	/**
	 * Export controllers
	 * 
	 * @return void
	 */
	 protected function exportControllers()
	 {
	 	foreach ($this->controllers as $key => $value) {
	 		file_put_contents(
                app_path($value),
                $this->compileControllerStub($key)
            );
		}
	 }
	 
	/**
	 * Export middlewares
	 * 
	 * @return void
	 */
	 protected function exportMiddlewares()
	 {
	 	foreach ($this->middlewares as $key => $value) {
	 		file_put_contents(
                app_path($value),
                $this->compileControllerStub($key)
            );
		}
	 }
	 
	 /**
	 * Export notifications
	 * 
	 * @return void
	 */
	 protected function exportNotifications()
	 {
	 	foreach ($this->notifications as $key => $value) {
	 		file_put_contents(
                app_path($value),
                $this->compileControllerStub($key)
            );
		}
	 }
	
	/**
     * Compiles a Controller stub.
     *
	 * @param string $dir
	 * @param boolean $rtrim
     * @return string
     */
    protected function compileControllerStub($dir, $rtrim = false)
    {
        return str_replace(
            '{{namespace}}',
            ($rtrim ? rtrim($this->getAppNamespace(), '\\') : $this->getAppNamespace()),
            file_get_contents(__DIR__.$dir)
        );
    }
}