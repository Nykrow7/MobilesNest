<?php

namespace App\Providers;

use App\Helpers\CurrencyHelper;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Request;
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
        // Use Tailwind CSS for pagination styling by default
        Paginator::useTailwind();

        // Register a Blade directive for currency formatting
        Blade::directive('peso', function ($expression) {
            return "<?php echo App\Helpers\CurrencyHelper::formatPeso($expression); ?>";
        });

        // Add links() method to Eloquent Collection
        Collection::macro('links', function (string $view = null, array $data = []) {
            $paginator = new LengthAwarePaginator(
                $this->forPage(LengthAwarePaginator::resolveCurrentPage(), $perPage = 15),
                $this->count(),
                $perPage,
                LengthAwarePaginator::resolveCurrentPage(),
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => 'page',
                ]
            );

            return $paginator->withQueryString()->links($view, $data);
        });

        // Add withQueryString() method to Eloquent Collection
        Collection::macro('withQueryString', fn () => $this);
    }
}
