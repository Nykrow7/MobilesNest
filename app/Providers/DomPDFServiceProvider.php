<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\App;

class DomPDFServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('dompdf', function () {
            $options = new Options();
            $options->set('defaultFont', 'sans-serif');
            $options->set('isRemoteEnabled', true);

            $dompdf = new Dompdf($options);
            $dompdf->setBasePath(public_path());

            return $dompdf;
        });

        $this->app->singleton('pdf', function () {
            return new \App\Services\PDF($this->app->make('dompdf'));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
