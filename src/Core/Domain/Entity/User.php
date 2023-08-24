<?php declare(strict_types=1);

namespace Water\Core\Domain\Entity;

final class User
{
  public function __construct(
    public readonly string $document,
    private string $name,
    private ?int $drankedWater,
    // private Account $userAccount
  ) {
  }

  public function drankedWater(): int
  {
    return is_null($this->drankedWater) ? 0 : $this->drankedWater;
  }

  public function drinkWater(): void
  {
    $this->drankedWater += 1;
  }

  public function name(): string
  {
    return $this->name;
  }
}
