<?php declare(strict_types=1);

namespace Water\Module\Access\Domain\Exception;

use Exception;
use Throwable;

final class PasswordException extends Exception
{
  public function __construct($message = "", $code = 0, Throwable $previous = null)
  {
    parent::__construct($message, $code, $previous);
  }
}
