<?php declare(strict_types=1);

/**
 * @see bootstrap/boot/routes.php
 * @see HttpSoft\Basis\Application
 * @see HttpSoft\Router\RouteCollector
 */

use Controller\Web\HomeAction;
use Controller\Web\Doc\DocApiController;
use Water\Module\Access\Infra\Http\Controller\LogController;

$route->get('/', '', HomeAction::class);

$route->get('/doc/api', '/doc/api', DocApiController::class);

$route->get('/log', '/log', LogController::class);

// $route->group('/user', function (RouteCollector $router) {
//   $router->get('user.list', '', ListAction::class);
//   $router->get('user.view', '/{id}', ViewAction::class)->tokens(['id' => '\d+']);
// });