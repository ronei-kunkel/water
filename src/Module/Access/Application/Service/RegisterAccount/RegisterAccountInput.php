<?php declare(strict_types=1);

namespace Water\Module\Access\Application\Service\RegisterAccount;

final class RegisterAccountInput
{

  public function __construct(
    public readonly string $document,
    public readonly string $email,
    public readonly string $password
  ) {
  }

}
