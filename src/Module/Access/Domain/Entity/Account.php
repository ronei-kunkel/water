<?php declare(strict_types=1);

namespace Water\Module\Access\Domain\Entity;

final class Account
{
  public function __construct(
    public readonly string $document,
    private string $email,
    private string $password
  ) {
  }

  public function email(): string
  {
    return $this->email;
  }

  public function password(): string
  {
    return $this->password;
  }
}
