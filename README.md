# Instruções de Uso do Docker

Este repositório contém um ambiente Dockerizado para executar um aplicativo com PostgreSQL.

## Rodando o Docker

1. Certifique-se de ter o Docker instalado em sua máquina. Se não tiver, você pode baixá-lo [aqui](https://www.docker.com/get-started).
2. Clone este repositório para sua máquina local.
3. Navegue até o diretório raiz do repositório.
4. Execute o seguinte comando para construir e iniciar o contêiner Docker:

    ```bash
    docker-compose up -d
    ```

5. Aguarde até que o Docker inicie o contêiner. Uma vez iniciado, você poderá acessar o aplicativo em http://localhost:8080.

## Removendo o Volume do Banco de Dados

Se você deseja remover completamente os dados do banco de dados, incluindo o volume do Docker:

1. Pare o contêiner Docker executando:

    ```bash
    docker-compose down
    ```

2. Execute o seguinte comando para remover o volume do banco de dados:

    ```bash
    docker volume rm nome_do_volume
    ```

Substitua `nome_do_volume` pelo nome do volume do banco de dados, que geralmente é o nome do diretório onde os dados do PostgreSQL são armazenados.

## Dando um Dump no Banco de Dados Usando o Docker

Para fazer um dump do banco de dados PostgreSQL:

1. Execute o seguinte comando para criar um dump do banco de dados:

    ```bash
    docker exec -i seu_contêiner_postgres pg_dump -U seu_usuario -d nome_do_banco > dump.sql
    ```

   - `seu_contêiner_postgres` é o nome ou ID do contêiner Docker onde o PostgreSQL está em execução.
   - `seu_usuario` é o nome do usuário do PostgreSQL que você está usando para fazer o dump.
   - `nome_do_banco` é o nome do banco de dados que você deseja fazer o dump.
   - `dump.sql` é o arquivo onde o dump do banco de dados será salvo.
