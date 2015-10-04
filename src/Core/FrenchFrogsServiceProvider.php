<?php namespace FrenchFrogs\Core;
use FrenchFrogs;
use Illuminate\Support\ServiceProvider;
use Response, Request;

/**
 * Service provider for frenchfrogs
 *
 * Class FrenchFrogsServiceProvider
 * @package FrenchFrogs\Core
 */
class FrenchFrogsServiceProvider  extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        foreach(config('frenchfrogs') as $namespace => $config) {
            configurator($namespace)->merge($config);
        }
    }


    public function boot()
    {
        Response::macro('modal', function($title, $body = '', $actions  = [])
        {
            if ($title instanceof FrenchFrogs\Polliwog\Modal\Modal\Bootstrap) {
                $modal = $title;
            } else {
                $modal = modal($title, $body, $actions);
            }
            $modal->setCloseButton(false);

            // As it's an ajax request, we render only the content
            $modal->remote();
            return $modal;
        });
    }
}