<?php declare(strict_types=1);

namespace Water\Module\Access\Domain\Exception;

use DomainException;
use Throwable;

final class EmailException extends DomainException
{
  public function __construct($message = "", $code = 0, Throwable $previous = null)
  {
    parent::__construct($message, $code, $previous);
  }
}
