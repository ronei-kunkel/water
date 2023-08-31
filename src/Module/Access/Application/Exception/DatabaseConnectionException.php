<?php declare(strict_types=1);

namespace Water\Module\Access\Application\Exception;

use PDOException;
use Throwable;

final class DatabaseConnectionException extends PDOException
{
  public ?array $errorInfo;
  public function __construct($message = "", $code = 0, $errorInfo = null, Throwable $previous = null)
  {
    $this->errorInfo = $errorInfo;
    parent::__construct($message, $code, $previous);
  }
}
