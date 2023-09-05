<?php declare(strict_types=1);

namespace Water\Module\Access\Infra\Http\Controller;

use HttpSoft\Response\HtmlResponse;
use Water\Module\Access\Application\Service\Log\LogInput;
use Water\Module\Access\Application\Service\Log\LogService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class LogController implements RequestHandlerInterface
{

  public function __construct(
    private LogService $service
  ){
  }

  /**
   * {@inheritDoc}
   */
  public function handle(ServerRequestInterface $request): ResponseInterface
  {

    // TODO: Request validator

    $data = $request->getQueryParams();

    $input = new LogInput($data['hash'] ?? '');

    $output = $this->service->execute($input);

    return new HtmlResponse($output->message, $output->code());
  }
}
