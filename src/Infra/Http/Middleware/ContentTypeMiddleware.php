<?php

declare(strict_types=1);

namespace Water\Infra\Http\Middleware;

use HttpSoft\Basis\Exception\BadRequestHttpException;
use HttpSoft\Message\Response;
use HttpSoft\Message\Stream;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class ContentTypeMiddleware implements MiddlewareInterface
{
  /**
   * {@inheritDoc}
   *
   * @throws BadRequestHttpException
   * @link https://tools.ietf.org/html/rfc7231
   * @psalm-suppress MixedArgument
   * @psalm-suppress MixedAssignment
   */
  public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
  {
    $explodedTarget = array_filter(explode('/', $request->getRequestTarget()));
    $apiTarget      = array_shift($explodedTarget) === 'api';

    $contentType = $request->getHeaderLine('Content-Type');

    if (!in_array($contentType, ['application/json', 'text/html; charset=utf-8', 'text/html'])) {
      $stream = new Stream();
      $stream->write(json_encode([
        'status' => false,
        'message' => 'Content-Type only accept: \'application/json\', \'text/html; charset=utf-8\', \'text/html\''
      ]));
      return new Response(statusCode: 400, body: $stream);
    }

    if ($apiTarget and $contentType !== 'application/json'){
      $stream = new Stream();
      $stream->write(json_encode([
        'status' => false,
        'message' => 'Api accept only \'application/json\' as Content-Type'
      ]));
      return new Response(statusCode: 400, body: $stream);
    }

    if (!$apiTarget and $contentType === 'application/json'){
      $stream = new Stream();
      $stream->write(json_encode([
        'status' => false,
        'message' => 'Only api accept \'application/json\' as Content-Type'
      ]));
      return new Response(statusCode: 400, body: $stream);
    }

    return $handler->handle($request);
  }
}