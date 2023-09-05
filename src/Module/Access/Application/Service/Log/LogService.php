<?php declare(strict_types=1);

namespace Water\Module\Access\Application\Service\Log;

use DomainException;
use Exception;
use Throwable;
use Water\Module\Access\Application\Service\ServiceOutput;

final class LogService
{
  public function __construct(
  ) {
  }

  public function execute(LogInput $input): ServiceOutput
  {

    $status  = false;
    $message = 'Unknown error';
    $code    = 500;
    // $event  = null;

    try {

      if($input->hash !== $_ENV['HASH'])
        throw new Exception('Wrong hash', 403);

      $status = file_exists('/var/www/water/'.$_ENV['LOG_PATH']);

      if(!$status)
        throw new Exception('Log not found', 404);

      $logs = $status ? file_get_contents('/var/www/water/'.$_ENV['LOG_PATH']) : 'oops';

      $html = '<!DOCTYPE html>
      <html lang="en">
      <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
      </head>
      <body>
        <pre>'.$logs.'</pre>
      </body>
      </html>';

      // TODO: utilizar fila para criação de usuario? Se sim, UserCreatedEvent e já retorno lá no finally
      // Tento persistir ela no banco
      $message = $html;
      $code    = 201;

      // TODO: disparo ElementSavedEvent com topic para user
    } catch (Throwable $e) {

      $status  = false;
      $message = $e->getMessage();
      $code    = (in_array($e->getCode(), [403, 404])) ? $e->getCode() : 500;
    }

    // TODO: Adiciono o evento para o QueueManager fazer o envio com base no tópico
    // TODO: o queueManager é responsável por criar a exchange e a fila caso não existam e as linkar

    // retorno o resultado da tentativa de persistir o dado
    return new ServiceOutput($status, $message, $code);
  }
}
