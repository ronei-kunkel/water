<?php declare(strict_types=1);

/**
 * @see bootstrap/boot/routes.php
 * @see HttpSoft\Basis\Application
 * @see HttpSoft\Router\RouteCollector
 */

use HttpSoft\Router\RouteCollector;
use Controller\Api\DocApiRedirectController;
use Water\Module\Access\Infra\Http\Controller\RegisterAccountController;

// redirect to doc
$route->get('/api', '/?', DocApiRedirectController::class);

// api v1
$route->group('/v1', function (RouteCollector $router) {

  // redirect to doc
  $router->get('/api/v1', '/?', DocApiRedirectController::class);

  $router->post('/api/v1/register', '/register', RegisterAccountController::class);
});