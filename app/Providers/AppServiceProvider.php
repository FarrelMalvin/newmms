<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register ImageHelper globally
        if (!class_exists('ImageHelper')) {
            class_alias(\App\Helpers\ImageHelper::class, 'ImageHelper');
        }

        // Register Blade directive for images
        \Blade::directive('productImage', function ($expression) {
            return "<?php echo \App\Helpers\ImageHelper::getProductImageUrl($expression); ?>";
        });

        \Blade::directive('imageUrl', function ($expression) {
            return "<?php echo \App\Helpers\ImageHelper::getImageUrl($expression); ?>";
        });
    }
}
