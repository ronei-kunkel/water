<?php declare(strict_types=1);

namespace Water\Module\Access\Domain\Type\Password;

use Water\Module\Access\Domain\Exception\PasswordException;
use Water\Module\Access\Domain\Type\Password;

final class RawPassword extends Password
{
  public function __construct(
    protected readonly string $value
  ) {
    if(strlen($this->value) < self::MIN_DIGITS)
      throw new PasswordException("Password must be at least 6 characters");

    $this->raw = true;
  }
}
