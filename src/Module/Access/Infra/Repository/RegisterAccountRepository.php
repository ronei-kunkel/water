<?php declare(strict_types=1);

namespace Water\Module\Access\Infra\Repository;

use Water\Module\Access\Application\Exception\DatabaseCommitException;
use Water\Module\Access\Application\Exception\DatabaseConnectionException;
use Water\Module\Access\Application\Exception\DatabaseExecutionException;
use Water\Module\Access\Domain\Entity\Account;
use Water\Module\Access\Domain\Repository\Creator;
use PDO;
use PDOException;

final class RegisterAccountRepository implements Creator
{
  public function __construct(
    private PDO $connection
  ) {
  }

  /**
   * @throws DatabaseExecutionException
   * @throws DatabaseCommitException
   * @throws DatabaseConnectionException
   */
  public function create(Account $account): true
  {
    $accountSql = 'INSERT INTO user (document, email, password)
    VALUES (:document, :email, :password);';

    $accountParams = [
      ':document' => $account->document,
      ':email'    => $account->email(),
      ':password' => $account->password()
    ];

    $query = strtr($accountSql, $accountParams);

    // TODO: Desenvolver gerenciador de transações + uma forma de vincular o id da requisição à ação resultante
    // TODO: algo como $this->connection->addTransaction($accountSql, $accountParams)->transact($requestId);

    $this->connection->beginTransaction();

    try {

      $statement       = $this->connection->prepare($accountSql);
      $executionStatus = $statement->execute($accountParams);

      if (!$executionStatus) {
        if ($this->connection->inTransaction())
          $this->connection->rollBack();

        // TODO: disparar ExecutionFailedEvent com a query

        throw new DatabaseExecutionException("Error on executing changes", 0001);
      }

      $commitStatus = $this->connection->commit();

      if (!$commitStatus) {
        // TODO: disparar CommitFailedEvent com a query

        throw new DatabaseCommitException("Execution changes has been reverted because error on committing executed changes", 0002);
      }

    } catch (PDOException $e) {

      if ($this->connection->inTransaction())
        $this->connection->rollBack();

      // TODO: disparar PDOExceptionEvent com a query e erros

      throw new DatabaseConnectionException("Error on communication with database", 0003, $e->errorInfo, $e);
    }

    return true;
  }
}