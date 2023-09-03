<?php declare(strict_types=1);
use Water\Module\Access\Domain\Entity\Account;
use Water\Module\Access\Domain\Type\Password\RawPassword;
use Water\Module\Access\Domain\Type\Email;
use Water\Module\Access\Domain\Type\Password;
use Water\Module\Access\Domain\Type\Password\EncryptedPassword;
use Water\Module\Access\Domain\Builder\AccountBuilder;
use Water\Module\Access\Domain\Service\PasswordService;

test('Deve instanciar uma nova conta', function () {
  $document = '01234567890';
  $email = 'mail@xpto.com';
  $password = '123456';

  $account = new Account($document, new Email($email), new RawPassword($password));
  expect($account)->toBeInstanceOf(Account::class);
  expect($account->document())->toBeString();
  expect($account->document())->toBe($document);
  expect($account->email())->toBeInstanceOf(Email::class);
  expect((string)$account->email())->toBe($email);
  expect($account->password())->toBeInstanceOf(Password::class);
  expect((string)$account->password())->toBe($password);
});

test('Deve instanciar uma conta existente', function () {
  $document = '01234567890';
  $email = 'mail@xpto.com';
  $password = '$argon2id$v=19$m=65536,t=4,p=1$cy5mdll0N1pxOVY0Z1BBYw$YmIj96HgQnk5mUyjp3PzMYwTyMqgtJ0JiGLgdh8YW5w';

  $account = new Account($document, new Email($email), new EncryptedPassword($password));
  expect($account)->toBeInstanceOf(Account::class);
  expect($account->document())->toBeString();
  expect($account->document())->toBe($document);
  expect($account->email())->toBeInstanceOf(Email::class);
  expect((string)$account->email())->toBe($email);
  expect($account->password())->toBeInstanceOf(Password::class);
  expect((string)$account->password())->toBe($password);
});

test('Deve montar uma nova conta com uma nova senha e a senha da conta deve ser retornada de forma encriptada', function () {
  $document = '01234567890';
  $email = 'mail@xpto.com';
  $password = '123456';
  $service = new PasswordService();
  $builder = new AccountBuilder($service);

  $account = $builder->withDocument($document)
    ->withEmail($email)
    ->withNewPassword($password)
    ->build();

  expect($account)->toBeInstanceOf(Account::class);
  expect($account->document())->toBeString();
  expect($account->document())->toBe($document);
  expect($account->email())->toBeInstanceOf(Email::class);
  expect((string)$account->email())->toBe($email);
  expect($account->password())->toBeInstanceOf(Password::class);
  expect((string)$account->password())->not()->toBe($password);
});

test('Deve montar uma conta existente com a senha encriptada salva', function () {
  $document = '01234567890';
  $email = 'mail@xpto.com';
  $password = '$argon2id$v=19$m=65536,t=4,p=1$cy5mdll0N1pxOVY0Z1BBYw$YmIj96HgQnk5mUyjp3PzMYwTyMqgtJ0JiGLgdh8YW5w';
  $service = new PasswordService();
  $builder = new AccountBuilder($service);

  $account = $builder->withDocument($document)
    ->withEmail($email)
    ->withSavedPassword($password)
    ->build();

  expect($account)->toBeInstanceOf(Account::class);
  expect($account->document())->toBeString();
  expect($account->document())->toBe($document);
  expect($account->email())->toBeInstanceOf(Email::class);
  expect((string)$account->email())->toBe($email);
  expect($account->password())->toBeInstanceOf(Password::class);
  expect((string)$account->password())->toBe($password);
});