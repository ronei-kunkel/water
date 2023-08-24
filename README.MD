# WATER

## O QUE É

Water é um sistema que tem por finalidade gerenciar a quantidade de vezes que um usuário bebeu água.

## REQUISITOS

- composer
- docker
- docker-compose

## COMO RODAR

Siga os passos a seguir para rodar o projeto em sua máquina:

- Apenas acesse a pasta do projeto pelo terminal e rode `composer setup`

## MVP

### REQUISITOS FUNCIONAIS

- criar e permitir acesso de um usuário ao sistema
- editar ou remover um usuário
- gerenciar o número de vezes que um usuário bebeu água

### REQUISITOS NÃO FUNCIONAIS

- testes unitários e de integração
- entradas e saídas da api rest devem ser em json
- perisitência com mysql
- contêiner de injeção de dependência

## BÔNUS

### REQUISITOS FUNCIONAIS

- ranqueamento de usuários por quantidade de vezes que bebeu água em períodos de tempo (abordagem de Event Sourcing)

### REQUISITOS NÃO FUNCIONAIS

- arquitetura orientada a eventos (Mensageria)
- mensageria com rabbit mq

## DOCUMENTAÇÃO

TODO