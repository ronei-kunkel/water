<?php declare(strict_types=1);

namespace Water\Module\Access\Domain\Service;

use Water\Module\Access\Domain\Type\Password\EncryptedPassword;
use Water\Module\Access\Domain\Type\Password\RawPassword;

final class PasswordService
{
  public function encrypt(RawPassword $rawPassword): EncryptedPassword
  {
    $password = password_hash((string) $rawPassword, $rawPassword->algoName(), $rawPassword->options());
    return new EncryptedPassword($password);
  }

  public function verify(RawPassword $rawPassword, EncryptedPassword $encryptedPassword): bool
  {
    return password_verify((string) $rawPassword, (string) $encryptedPassword);
  }
}
