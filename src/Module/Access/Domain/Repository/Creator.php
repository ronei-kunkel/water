<?php declare(strict_types=1);

namespace Water\Module\Access\Domain\Repository;

use Water\Module\Access\Domain\Entity\Account;

interface Creator
{
  public function Create(Account $account): true;
}
