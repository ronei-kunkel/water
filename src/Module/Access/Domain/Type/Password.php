<?php declare(strict_types=1);

namespace Water\Module\Access\Domain\Type;

use Stringable;

abstract class Password implements Stringable
{
  protected const ALGORITHM = PASSWORD_ARGON2ID;
  protected const ALGORITHM_OPTIONS = [
    'memory_cost' => PASSWORD_ARGON2_DEFAULT_MEMORY_COST,
    'time_cost'   => PASSWORD_ARGON2_DEFAULT_TIME_COST,
    'threads'     => PASSWORD_ARGON2_DEFAULT_THREADS,
  ];
  protected const MIN_DIGITS = 6;
  protected readonly string $value;
  protected bool $raw;

  public function __toString(): string
  {
    return $this->value;
  }

  public function algoName(): string
  {
    return self::ALGORITHM;
  }
  public function options(): array
  {
    return self::ALGORITHM_OPTIONS;
  }
}
