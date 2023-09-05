<?php declare(strict_types=1);

/**
 * @see bootstrap/boot/pipeline.php
 * @see https://httpsoft.org/docs/runner/v1/middleware-pipeline
 */

use Water\Infra\Http\Middleware\ContentTypeMiddleware;

// Pipe here any custom middleware that you want to execute on every request or for specific paths.

$app->pipe(ContentTypeMiddleware::class);