<?php declare(strict_types=1);

namespace Water\Module\Access\Application\Service\RegisterAccount;

final class RegisterAccountOutput
{

  public function __construct(
    public readonly string $message,
    public readonly bool $status
  ) {
  }

}