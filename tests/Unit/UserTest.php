<?php declare(strict_types=1);

use Water\Core\Domain\Builder\UserBuilder;
use Water\Core\Domain\Entity\User;

test('Usuário deve ser criado', function () {
  $user = new User('01234567890', 'Name', 0);
  expect($user->drankedWater())->toBe(0);
  expect($user->document)->toBe('01234567890');
});

test('Usuário deve beber água', function () {
  $user = new User('01234567890', 'Name', 0);
  expect($user->drankedWater())->toBe(0);
  $user->drinkWater();
  expect($user->drankedWater())->toBe(1);
  expect($user->document)->toBe('01234567890');
});

test('Deve montar um novo usuário', function () {
  $userBuilder = new UserBuilder('01234567890', 'Name');
  $user = $userBuilder->build();

  expect($user->document)->toBe('01234567890');
  expect($user->name())->toBe('Name');
  expect($user->drankedWater())->toBe(0);
});

test('Deve montar um usuário existente', function () {
  $userBuilder = new UserBuilder('01234567890', 'Name');
  $user = $userBuilder->setDrinkedWater(15)
    ->build();

  expect($user->document)->toBe('01234567890');
  expect($user->name())->toBe('Name');
  expect($user->drankedWater())->toBe(15);
});

test('Usuário deve ser criado pelo serviço de criação de usuários', function () {
  $userCacheMemory = new UserCacheMemory();

  $userRepositoryMemory = new UserRepositoryMemory($userCacheMemory);

  $createUserApplicationService = new CreateUserApplicationService($userRepositoryMemory);
  $createUserApplicationService->handle('01234567890', 'Name');

  $getterUserApplicationService = new GetterUserApplicationService($userRepositoryMemory);
  $user = $getterUserApplicationService->handle('01234567890');

  expect($user->drankedWater())->toBe(0);
});

test('Deve ser enviada uma mensagem para a fila quando o usuário beber água', function () {
  $userCacheMemory = new UserCacheMemory();

  $userRepositoryMemory = new UserRepositoryMemory($userCacheMemory);

  $createUserApplicationService = new CreateUserApplicationService($userRepositoryMemory);
  $createUserApplicationService->handle('01234567890', 'Name');

  $getterUserApplicationService = new GetterUserApplicationService($userRepositoryMemory);
  $user = $getterUserApplicationService->handle('01234567890');

  expect($user->drankedWater())->toBe(0);

  $drankWaterUserQueueMemory = new DrankWaterUserQueueMemory();

  expect($drankWaterUserQueueMemory->messages()->count())->toBe(0);

  $drankWaterUserQueueProducer = new DrankWaterUserQueueProducer($drankWaterUserQueueMemory);

  $drankWaterUserApplicationService = new DrankWaterUserApplicationService($drankWaterUserQueueProducer);
  $drankWaterUserApplicationService->handle();

  expect($drankWaterUserQueueMemory->messages()->count())->toBe(1);
});

test('A mensagem de que o usuário bebeu água deve ser lida, processada e removida', function () {
  $userCacheMemory = new UserCacheMemory();

  $userRepositoryMemory = new UserRepositoryMemory($userCacheMemory);

  $createUserApplicationService = new CreateUserApplicationService($userRepositoryMemory);
  $createUserApplicationService->handle('01234567890', 'Name');

  $getterUserApplicationService = new GetterUserApplicationService($userRepositoryMemory);
  $user = $getterUserApplicationService->handle('01234567890');

  expect($user->drankedWater())->toBe(0);

  $drankWaterUserQueueMemory = new DrankWaterUserQueueMemory();

  expect($drankWaterUserQueueMemory->messages()->count())->toBe(0);

  $drankWaterUserQueueProducer = new DrankWaterUserQueueProducer($drankWaterUserQueueMemory);
  $drankWaterUserQueueConsumer = new DrankWaterUserQueueConsumer();
  $drankWaterUserQueueProducer->registerConsumer($drankWaterUserQueueConsumer);

  $drankWaterUserApplicationService = new DrankWaterUserApplicationService($drankWaterUserQueueProducer);
  // dentro de handle vai ser feita a criação do comando,
  // o envio da mensagem pra fila e em seguida
  // ativar a escuta do consumidor por meio de $drankWaterUserQueueProducer->triggerConsumers()
  // ao trigar cada um dos consumidores por meio de $consumer->consume()
  // a mensagem é lida, processada (salva no banco e no cache) e removida da fila
  $drankWaterUserApplicationService->handle();

  expect($drankWaterUserQueueMemory->messages()->count())->toBe(0);

  $getterUserApplicationService = new GetterUserApplicationService($userRepositoryMemory);
  $user = $getterUserApplicationService->handle('01234567890');

  expect($user->drankedWater())->toBe(1);
});
