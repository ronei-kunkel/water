<?php declare(strict_types=1);

namespace Water\Module\Access\Application\Exception;

use PDOException;
use Throwable;

final class DatabaseConnectionException extends PDOException
{
  public ?array $errorInfo;

  private $mappedErrors = [
    '23000' => [
      'message' => 'already exists',
      'code'    => 409
    ]
  ];

  public function __construct($message = "", $code = 0, $errorInfo = null, Throwable $previous = null)
  {
    $this->errorInfo = $errorInfo;
    parent::__construct($message, $code, $previous);
  }

  public function getMappedErrorMessage(): ?string
  {
    return $this->mappedErrors[$this->errorInfo[0]]['message'] ?? null;
  }

  public function getMappedErrorCode(): ?int
  {
    return $this->mappedErrors[$this->errorInfo[0]]['code'] ?? null;
  }
}