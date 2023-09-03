<?php declare(strict_types=1);

namespace Water\Module\Access\Domain\Type\Password;

use Water\Module\Access\Domain\Exception\PasswordException;
use Water\Module\Access\Domain\Type\Password;

final class EncryptedPassword extends Password
{
  public function __construct(
    protected readonly string $value
  ) {
    if(password_get_info($this->value)['algoName'] !== self::ALGORITHM)
      throw new PasswordException("Saved password is corrupted");

    $this->raw = false;
  }

}
