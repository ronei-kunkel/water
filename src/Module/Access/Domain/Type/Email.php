<?php declare(strict_types=1);

namespace Water\Module\Access\Domain\Type;
use Water\Module\Access\Domain\Exception\EmailException;

final class Email
{
  public function __construct(
    private string $email
  ) {
    if (!filter_var($this->email, FILTER_VALIDATE_EMAIL))
      throw new EmailException("Invalid email address");
  }

  public function __toString(): string
  {
    return $this->email;
  }
}