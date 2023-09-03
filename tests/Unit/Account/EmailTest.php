<?php declare(strict_types=1);
use Water\Module\Access\Domain\Type\Email;
use Water\Module\Access\Domain\Exception\EmailException;

test('Deve instanciar um email', function () {
  $value = 'example@xpto.com';

  $email = new Email($value);
  expect((string)$email)->toBe($value);
});

test('Deve lançar uma excessão ao tentar instanciar um email inválido', function () {
  $value = 'email_invalido@example';

  expect(fn () => new Email($value))->toThrow(EmailException::class, 'Invalid email address');
});
