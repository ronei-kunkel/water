<?php declare(strict_types=1);

namespace Water\Module\Access\Application\Service\Log;

final class LogInput
{
  public function __construct(
    public readonly string $hash
  ) {
  }
}