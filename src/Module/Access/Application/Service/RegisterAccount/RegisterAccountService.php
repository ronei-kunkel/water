<?php declare(strict_types=1);

namespace Water\Module\Access\Application\Service\RegisterAccount;

use DomainException;
use Water\Module\Access\Application\Exception\DatabaseCommitException;
use Water\Module\Access\Application\Exception\DatabaseConnectionException;
use Water\Module\Access\Application\Exception\DatabaseExecutionException;
use Water\Module\Access\Application\Service\ServiceOutput;
use Water\Module\Access\Infra\Repository\RegisterAccountRepository;
use Water\Module\Access\Domain\Builder\AccountBuilder;

final class RegisterAccountService
{
  public function __construct(
    private RegisterAccountRepository $repository,
    private AccountBuilder $accountBuilder
  ) {
  }

  public function execute(RegisterAccountInput $input): ServiceOutput
  {

    $status  = false;
    $message = 'Unknown error';
    $code    = 500;
    // $event  = null;

    try {

      $account = $this->accountBuilder->withDocument($input->document)
        ->withEmail($input->email)
        ->withNewPassword($input->password)
        ->build();

      // TODO: utilizar fila para criação de usuario? Se sim, UserCreatedEvent e já retorno lá no finally
      // Tento persistir ela no banco
      $status  = $this->repository->create($account);
      $message = 'Account successfuly created';
      $code    = 201;

      // TODO: disparo ElementSavedEvent com topic para user
    } catch (DomainException | DatabaseExecutionException | DatabaseCommitException $e) {

      $status  = false;
      $message = $e->getMessage();
      $code    = $e->getCode();

    } catch (DatabaseConnectionException $e) {

      $errorInfo    = $e->errorInfo;
      $errorMessage = $e->getPrevious()->getMessage();

      $status  = false;
      $message = $_ENV['DEBUG'] ? $errorMessage : $e->getMessage();
      $code    = $e->getCode();

    }

    // TODO: Adiciono o evento para o QueueManager fazer o envio com base no tópico
    // TODO: o queueManager é responsável por criar a exchange e a fila caso não existam e as linkar

    // retorno o resultado da tentativa de persistir o dado
    return new ServiceOutput($message, $status, $code);
  }
}
