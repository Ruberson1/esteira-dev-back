
# Backend do Sistema de Esteira de Desenvolvimento

Este é o componente backend do nosso sistema de esteira de desenvolvimento, responsável por gerenciar a lógica de negócios, a persistência de dados e a comunicação com o frontend.

## Tecnologias Utilizadas

O backend foi desenvolvido utilizando as seguintes tecnologias:

- **PHP**: Uma linguagem de programação amplamente usada para o desenvolvimento web.

- **Lumen Framework**: Um micro-framework PHP que é uma versão mais leve e eficiente do Laravel, projetado para criar aplicativos web e APIs rápidas e eficazes.

## Funcionalidades Principais

O backend oferece as seguintes funcionalidades:

1. **API RESTful**: O sistema backend fornece uma API RESTful que permite ao frontend realizar operações de CRUD (Create, Read, Update, Delete) em tarefas, bem como gerenciar o progresso das mesmas.

2. **Autenticação e Autorização**: Implementa autenticação e autorização para garantir que apenas usuários autorizados possam acessar e modificar dados relacionados às tarefas.

3. **Conexão com o Banco de Dados**: O backend se conecta a um banco de dados para armazenar e recuperar informações sobre tarefas, usuários e outras entidades relacionadas.

4. **Integração com o Frontend**: Permite que o frontend envie solicitações HTTP para criar, recuperar, atualizar e excluir tarefas, bem como alterar seu status e mover-se ao longo da esteira de desenvolvimento.

## Como Iniciar

Para iniciar o backend em seu ambiente local, siga estas etapas:

1. Clone este repositório ou faça o download dos arquivos do backend.

2. Certifique-se de ter o PHP instalado em seu sistema.

3. Instale as dependências do projeto usando o Composer com o comando `composer install`.

4. Configure as informações de conexão com o banco de dados no arquivo `.env`.

5. Execute o servidor usando o comando `php -S localhost:8000 -t public`. O backend estará acessível em `http://localhost:8000` (ou outra porta, se configurada de forma diferente).
