<?php declare(strict_types=1);

namespace Water\Core\Domain\Builder;
use Water\Core\Domain\Entity\User;

final readonly class UserBuilder
{
  private ?int $drinkedWater;

  public function __construct(
    private string $document,
    private string $name,
  ){
  }

  public function setDrinkedWater(int $drinkedWater): self
  {
    $this->drinkedWater = $drinkedWater;
    return $this;
  }

  public function build(): User
  {
    return new User($this->document, $this->name, $this->drinkedWater ?? 0);
  }
}