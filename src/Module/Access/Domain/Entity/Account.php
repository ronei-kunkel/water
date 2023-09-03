<?php declare(strict_types=1);

namespace Water\Module\Access\Domain\Entity;

use Water\Module\Access\Domain\Type\Email;
use Water\Module\Access\Domain\Type\Password;

final class Account
{
  public function __construct(
    public readonly string $document,
    private Email $email,
    private Password $password
  ) {
  }

  public function document(): string
  {
    return $this->document;
  }

  public function email(): Email
  {
    return $this->email;
  }

  public function password(): Password
  {
    return $this->password;
  }
}
