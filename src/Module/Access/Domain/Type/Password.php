<?php declare(strict_types=1);

namespace Water\Module\Access\Domain\Type;

use Stringable;
use Water\Module\Access\Domain\Exception\PasswordException;

final class Password implements Stringable
{
  public function __construct(
    private readonly string $value,
    private readonly bool $raw
  ) {
    if ($this->raw)
      $this->encrypt();
  }

  public function __toString(): string
  {
    return $this->value;
  }

  private function encrypt(): void
  {
    if (!$this->raw)
      throw new PasswordException("Cannot encrypt an encrypted password");

    $this->value = password_hash($this->value, PASSWORD_ARGON2ID);
  }

  public function verify(string $password): bool
  {
    if ($this->raw)
      throw new PasswordException("Cannot verify both raw password");

    return  password_verify($password, $this->value);
  }
}