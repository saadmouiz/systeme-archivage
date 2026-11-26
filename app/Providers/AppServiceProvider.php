<?php

namespace App\Providers;

use App\Support\ArabicPdfText;
use Illuminate\Support\Facades\Blade;
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
        Blade::directive('pdfText', function ($expression) {
            return "<?php echo e(\\App\\Support\\ArabicPdfText::format($expression)); ?>";
        });
    }
}

