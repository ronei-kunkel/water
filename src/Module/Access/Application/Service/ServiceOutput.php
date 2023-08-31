<?php declare(strict_types=1);

namespace Water\Module\Access\Application\Service;

final class ServiceOutput
{

  public function __construct(
    public readonly string $message,
    public readonly bool $status,
    private readonly int $code
  ) {
  }

  public function code(): int
  {
    return $this->code;
  }

}