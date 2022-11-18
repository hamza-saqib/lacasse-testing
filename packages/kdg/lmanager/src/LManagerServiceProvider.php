<?php
	// MyVendor\contactform\src\ContactFormServiceProvider.php
    namespace KDG\LManager;
    use Illuminate\Support\ServiceProvider;
    class LManagerServiceProvider extends ServiceProvider {
        public function boot()
        {
            /*echo substr(__DIR__, -25);
            die;*/
            config(['lmanager_path' => substr(__DIR__, -25)]);

            if (file_exists($file = __DIR__.'/constants.php')) {
                require_once $file;
            }
            /*if (file_exists($file = __DIR__.'LanguageHelper.php')) {
                die('222222222');
                require_once $file;
            }
            die('here');*/
        	// MyVendor\contactform\src\ContactFormServiceProvider.php
    		$this->loadRoutesFrom(__DIR__.'/routes/web.php');
            // MyVendor\contactform\src\ContactFormServiceProvider.php
            $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
            // MyVendor\contactform\src\ContactFormServiceProvider.php
            $this->loadViewsFrom(__DIR__.'/resources/views', 'lmanager');

            $this->publishes([
                __DIR__.'/resources/views' => base_path('resources/views/kdg/lmanager'),
            ]);
        }
        public function register()
        {
            //$this->app->make('MyVendor\Contactform\Http\Controllers\ContactFormController');
        }
    }