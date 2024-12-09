# Projeto - Sistema de Gestão de Vinhos e Vendas - API

Instalador e ambiente de execução baseado em [Docker](https://www.docker.com/) para o framework web [Symfony](https://symfony.com), com [FrankenPHP](https://frankenphp.dev) e [Caddy](https://caddyserver.com/) integrados!


## Introdução

Iniciando:

#### 1º Passo:
Execute `docker compose build --no-cache` para compilar imagens novas.

#### 2º Passo:
Execute `docker compose up --pull always -d --wait` para configurar e iniciar um novo projeto Symfony.

#### 3º Passo:
Abra `https://localhost` no seu navegador favorito e [aceite o certificado TLS](https://stackoverflow.com/a/15076602/1352334) gerado automaticamente.

#### 4º Passo:
Execute `docker compose down --remove-orphans` para parar os contêineres Docker.

Para saber mais sobre as configurações e funcionalidades que dispõe Symfony Docker, pode ser acessado o [GitHub dunglas/symfony-docker](https://github.com/dunglas/symfony-docker).


## Resumo do projeto

### `- Sobre o sistema`
Este projeto é um sistema de gestão de vinhos e vendas desenvolvido com Symfony e Doctrine ORM. Ele permite o gerenciamento de vinhos e vendas, incluindo o cálculo do valor do frete e do total geral de cada venda com base em regras de negócio bem definidas.

### `- Tecnologias utilizadas`

#### Symfony:
Symfony 7 foi utilizado como base para o desenvolvimento do backend, o que garante uma estrutura sólida e bem organizada para a criação de APIs.

#### Doctrine ORM:
Para mapeamento e gerenciamento de entidades.

#### MySQL: 
Banco de dados relacional para persistência de dados.

### `- Passos para configuração`
1 - Clonar o repo: `git clone https://github.com/pablovt/app-ecommerce-api` \
2 - Instale as dependências: `composer install` \
3 - Configure o banco de dados no arquivo `.env`: 
`mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=8.4.3&charset=utf8mb4"
` \
4 - Execute as migrations: `php bin/console doctrine:database:create` e `
php bin/console doctrine:migrations:migrate` 



### Endpoints da API
#### Vinho: 
Consulta aos registros de vinho:
 - GET `/api/vinhos`

Cadastra um novo vinho:
 - POST `/api/vinhos`
 Exemplo:
    `{
	"nome": "Merlot",
	"tipo": "seco",
	"peso": "3.500"
    }`

#### Venda:
Consulta a todas as vendas cadastradas:
 - GET `/api/vendas`

Cadastra uma nova venda com os produtos e calcula o frete e o total geral:
 - POST `/api/vendas`
 Exemplo:
    `{
        "distancia": 120,
        "produtos": [
            {
            "id": 1,
            "quantidade": 2
            },
            {
            "id": 2,
            "quantidade": 3
            }
        ]
    }`

#### Venda de Produtos: 
Consulta aos registros da venda de produtos:
 - GET `/api/vendaProdutos`
