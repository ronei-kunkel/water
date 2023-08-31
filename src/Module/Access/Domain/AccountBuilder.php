<?php declare(strict_types=1);

namespace Water\Module\Access\Domain;

use Water\Module\Access\Domain\Entity\Account;

final readonly class AccountBuilder
{

  private string $email;
  private string $password;

  public function __construct(
    private string $document,
  ){
  }

  public function withEmail(string $email): self
  {
    $this->email = $email;
    return $this;
  }

  public function withPassword(string $password): self
  {
    $this->password = $password;
    return $this;
  }

  public function build(): Account
  {
    return new Account($this->document, $this->email, $this->password);
  }
}
