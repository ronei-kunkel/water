<?php declare(strict_types=1);

namespace Water\Module\Access\Infra\Http\Controller;

use HttpSoft\Response\JsonResponse;
use Water\Module\Access\Application\Service\RegisterAccount\RegisterAccountInput;
use Water\Module\Access\Application\Service\RegisterAccount\RegisterAccountService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class RegisterAccountController implements RequestHandlerInterface
{

  public function __construct(
    private RegisterAccountService $service
  ){
  }

  /**
   * {@inheritDoc}
   */
  public function handle(ServerRequestInterface $request): ResponseInterface
  {

    // TODO: Request validator

    $data = $request->getParsedBody();

    $input = new RegisterAccountInput($data['document'], $data['email'], $data['password']);

    $output = $this->service->execute($input);

    return new JsonResponse($output, $output->code());
  }
}
