<?php

namespace Sofa\Eloquence;

use Sofa\Eloquence\Mutator\Mutator;
use Illuminate\Support\ServiceProvider as BaseProvider;

/**
 * @codeCoverageIgnore
 */
class MutableServiceProvider extends BaseProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerMutator();
    }

    /**
     * Register attribute mutator service.
     *
     * @return void
     */
    protected function registerMutator()
    {
        $this->app->singleton('eloquence.mutator', function () {
            return new Mutator;
        });

        $this->app->alias('eloquence.mutator', 'Sofa\Eloquence\Contracts\Mutator');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['eloquence.mutator'];
    }
}
