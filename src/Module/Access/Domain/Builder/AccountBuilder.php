<?php declare(strict_types=1);

namespace Water\Module\Access\Domain\Builder;

use Water\Module\Access\Domain\Entity\Account;
use Water\Module\Access\Domain\Service\PasswordService;
use Water\Module\Access\Domain\Type\Email;
use Water\Module\Access\Domain\Type\Password;
use Water\Module\Access\Domain\Type\Password\RawPassword;
use Water\Module\Access\Domain\Type\Password\EncryptedPassword;

final readonly class AccountBuilder
{
  private string $document;
  private Email $email;
  private Password $password;

  public function __construct(
    private PasswordService $passwordService
  ) {
  }

  public function withDocument(string $document): self
  {
    $this->document = $document;
    return $this;
  }

  public function withEmail(string $email): self
  {
    $this->email = new Email($email);
    return $this;
  }

  public function withNewPassword(string $value): self
  {
    $password       = new RawPassword($value);
    $this->password = $this->passwordService->encrypt($password);

    return $this;
  }

  public function withSavedPassword(string $value): self
  {
    $this->password = new EncryptedPassword($value);

    return $this;
  }

  public function build(): Account
  {
    return new Account($this->document, $this->email, $this->password);
  }
}
