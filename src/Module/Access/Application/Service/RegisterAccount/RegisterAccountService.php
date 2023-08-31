<?php declare(strict_types=1);

namespace Water\Module\Access\Application\Service\RegisterAccount;
use Water\Module\Access\Infra\Repository\RegisterAccountRepository;
use Water\Module\Access\Domain\AccountBuilder;

final class RegisterAccountService
{
  public function __construct(
    private RegisterAccountRepository $repository
  ) {
  }

  public function execute(RegisterAccountInput $input): RegisterAccountOutput
  {
    $builder = new AccountBuilder($input->document);
    $account = $builder->withEmail($input->email)
      ->withPassword($input->password)
      ->build();

    $execution = $this->repository->create($account);

    return new RegisterAccountOutput('Account successful created', $execution);
  }
}
