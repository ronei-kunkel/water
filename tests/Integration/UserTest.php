<?php declare(strict_types=1);

// test('Usuário deve ser criado pelo serviço de criação de usuários', function () {
//   $userCache = new Cache();

//   $userRepository = new UserRepository($userCache);

//   $createUserApplicationService = new CreateUserApplicationService($userRepository);
//   $createUserApplicationService->handle('01234567890', 'Name');

//   $getterUserApplicationService = new GetterUserApplicationService($userRepository);
//   $user = $getterUserApplicationService->handle('01234567890');

//   expect($user->drankedWater())->toBe(0);
// });

// test('Deve ser enviada uma mensagem para a fila quando o usuário beber água', function () {
//   $userCache = new Cache();

//   $userRepository = new UserRepository($userCache);

//   $createUserApplicationService = new CreateUserApplicationService($userRepository);
//   $createUserApplicationService->handle('01234567890', 'Name');

//   $getterUserApplicationService = new GetterUserApplicationService($userRepository);
//   $user = $getterUserApplicationService->handle('01234567890');

//   expect($user->drankedWater())->toBe(0);

//   $drankWaterUserQueue = new DrankWaterUserQueue();

//   expect($drankWaterUserQueue->messages()->count())->toBe(0);

//   $drankWaterUserQueueProducer = new DrankWaterUserQueueProducer($drankWaterUserQueue);

//   $drankWaterUserApplicationService = new DrankWaterUserApplicationService($drankWaterUserQueueProducer);
//   $drankWaterUserApplicationService->handle();

//   expect($drankWaterUserQueue->messages()->count())->toBe(1);
// });

// test('A mensagem de que o usuário bebeu água deve ser lida, processada e removida', function () {
//   $userCache = new Cache();

//   $userRepository = new UserRepository($userCache);

//   $createUserApplicationService = new CreateUserApplicationService($userRepository);
//   $createUserApplicationService->handle('01234567890', 'Name');

//   $getterUserApplicationService = new GetterUserApplicationService($userRepository);
//   $user = $getterUserApplicationService->handle('01234567890');

//   expect($user->drankedWater())->toBe(0);

//   $drankWaterUserQueue = new DrankWaterUserQueue();

//   expect($drankWaterUserQueue->messages()->count())->toBe(0);

//   $drankWaterUserQueueProducer = new DrankWaterUserQueueProducer($drankWaterUserQueue);
//   $drankWaterUserQueueConsumer = new DrankWaterUserQueueConsumer();
//   $drankWaterUserQueueProducer->registerConsumer($drankWaterUserQueueConsumer);

//   $drankWaterUserApplicationService = new DrankWaterUserApplicationService($drankWaterUserQueueProducer);
//   // dentro de handle vai ser feita a criação do comando,
//   // o envio da mensagem pra fila e em seguida
//   // ativar a escuta do consumidor por meio de $drankWaterUserQueueProducer->triggerConsumers()
//   // ao trigar cada um dos consumidores por meio de $consumer->consume()
//   // a mensagem é lida, processada (salva no banco e no cache) e removida da fila
//   $drankWaterUserApplicationService->handle();

//   expect($drankWaterUserQueue->messages()->count())->toBe(0);

//   $getterUserApplicationService = new GetterUserApplicationService($userRepository);
//   $user = $getterUserApplicationService->handle('01234567890');

//   expect($user->drankedWater())->toBe(1);
// });