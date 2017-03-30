<?php

namespace Rdehnhardt\MaintenanceMode\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Rdehnhardt\MaintenanceMode\MaintenanceModeService;

class MaintenanceModeMiddleware
{
    /**
     * Maintenance Mode Service.
     *
     * @var \Rdehnhardt\MaintenanceMode\MaintenanceModeService
     */
    protected $maintenance;

    /**
     * MaintenanceModeMiddleware constructor.
     * @param MaintenanceModeService $maintenance
     */
    public function __construct(MaintenanceModeService $maintenance)
    {
        $this->maintenance = $maintenance;
    }

    /**
     * Handle incoming requests.
     *
     * @param Request $request
     * @param \Closure $next
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \InvalidArgumentException
     */
    public function handle($request, Closure $next)
    {
        if ($this->maintenance->isDownMode() && !$this->maintenance->checkAllowedIp($this->getIp())) {
            if (app()['view']->exists('errors.503')) {
                return new Response(app()['view']->make('errors.503'), 503);
            }

            return app()->abort(503, 'The application is down for maintenance.');
        }

        return $next($request);
    }

    /**
     * Get client ip
     */
    private function getIp()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }
}
