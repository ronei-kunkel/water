<?php declare(strict_types=1);
use Infra\Gateway\RabbitMqQueue;

test('Teste de conexão com a fila', function (){
  $connection = RabbitMqQueue::getConnection();
  expect($connection->isConnected())->toBeTrue();
});