<?php declare(strict_types=1);
use Water\Module\Access\Domain\Type\Password\RawPassword;
use Water\Module\Access\Domain\Service\PasswordService;
use Water\Module\Access\Domain\Type\Password\EncryptedPassword;
use Water\Module\Access\Domain\Exception\PasswordException;

test('Deve instanciar uma senha pura', function () {
  $value = '123456';

  $rawPassword = new RawPassword($value);
  expect((string)$rawPassword)->toBe($value);
});

test('Deve lançar uma excessão ao tentar instanciar uma senha pura muito curta', function () {
  $value = '12345';

  expect(fn () => new RawPassword($value))->toThrow(PasswordException::class, 'Password must be at least 6 characters');
});

test('Deve instanciar uma senha encriptada salva no banco', function () {
  $value = '$argon2id$v=19$m=65536,t=4,p=1$cy5mdll0N1pxOVY0Z1BBYw$YmIj96HgQnk5mUyjp3PzMYwTyMqgtJ0JiGLgdh8YW5w'; // 123456

  $encriptedPassword = new EncryptedPassword($value);

  expect((string)$encriptedPassword)->toBe($value);
});

test('Deve lançar uma excessão ao tentar instanciar uma senha encriptada com algoritmo diferente', function () {
  $value = '$2y$10$Ss6TEeUW.9Be898z177LCejCuMcbMc2LhIBlCFcnopl82FFQBRuD6'; // 123456 bcrypt

  expect(fn () => new EncryptedPassword($value))->toThrow(PasswordException::class, 'Saved password is corrupted');
});

test('Deve encriptar uma senha pura', function () {
  $value = '123456';
  $service = new PasswordService();

  $rawPassword = new RawPassword($value);
  $encriptedPassword = $service->encrypt($rawPassword);

  expect((string) $encriptedPassword)->toBeString();
  expect($encriptedPassword)->toBeInstanceOf(EncryptedPassword::class);
});

test('Deve retornar true na verificação da senha', function () {
  $entryValue = '123456';
  $savedValue = '$argon2id$v=19$m=65536,t=4,p=1$cy5mdll0N1pxOVY0Z1BBYw$YmIj96HgQnk5mUyjp3PzMYwTyMqgtJ0JiGLgdh8YW5w'; // 123456
  $service = new PasswordService();
  $rawPassword = new RawPassword($entryValue);
  $encryptedPassword = new EncryptedPassword($savedValue);

  $verified = $service->verify($rawPassword, $encryptedPassword);

  expect($verified)->toBeTrue();
});

test('Deve retornar false na verificação da senha', function () {
  $entryValue = '123456';
  $savedValue = '$argon2id$v=19$m=65536,t=4,p=1$LjZRa0Vtay92V0YuMDgxdA$VcPy4bXh+qzOndpEfH8AgLBfg/M6uId0yhy5a6abasw'; // abcdef
  $service = new PasswordService();
  $rawPassword = new RawPassword($entryValue);
  $encryptedPassword = new EncryptedPassword($savedValue);

  $verified = $service->verify($rawPassword, $encryptedPassword);

  expect($verified)->toBeFalse();
});

