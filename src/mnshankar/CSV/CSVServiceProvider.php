<?php
namespace mnshankar\CSV;

use Illuminate\Support\ServiceProvider;

class CSVServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        if (substr($this->app::VERSION,0,1) == '4') {
            $this->package('mnshankar/CSV');
        }
        $this->app['csv'] = $this->app->share(function () {
            return new CSV();
        });
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
