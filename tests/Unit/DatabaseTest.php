<?php

use Infra\Gateway\MysqlDatabase;

test('Conexão deve se comunicar com o banco', function () {

  $connection = MysqlDatabase::getConnection();

  $return = $connection->query('select 1 as valid;')->fetchObject();

  expect($return->valid)->toBe(1);
});