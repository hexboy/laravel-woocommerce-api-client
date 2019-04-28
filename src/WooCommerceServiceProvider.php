<?php namespace Hexboy\WooCommerce;

use Hexboy\WooCommerce\WooCommerceClient;
use Illuminate\Support\ServiceProvider;

class WooCommerceServiceProvider extends ServiceProvider
{
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
        $this->publishes([
            __DIR__ . '/../config/woocommerce.php' => config_path('woocommerce.php'),
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;

        // merge default config
        $this->mergeConfigFrom(__DIR__ . '/../config/woocommerce.php','woocommerce');

        $config = $app['config']->get('woocommerce');

        $app->singleton('Hexboy\WooCommerce\WooCommerceClient', function() use ($config) {
            return new WooCommerceClient(
                $config['store_url'],
                [
                    'version' => 'wc/'.$config['api_version'],
                    'verify_ssl' => $config['verify_ssl'],
                    'wp_api' => $config['wp_api'],
                    'query_auth_type' => $config['query_auth_type'],
                    'timeout' => $config['timeout'],
                ]);
        });

        $app->alias('Hexboy\WooCommerce\WooCommerceClient', 'woocommerce');
    }
}
