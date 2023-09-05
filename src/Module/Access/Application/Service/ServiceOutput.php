<?php declare(strict_types=1);

namespace Water\Module\Access\Application\Service;

final class ServiceOutput
{
  public function __construct(
    public readonly bool $status,
    public readonly string $message,
    private readonly int $code
  ) {
  }

  public function code(): int
  {
    return $this->code;
  }
}
