# API de Gerenciamento de Tarefas

Essa api foi desenvolvida com Slim no intuito de criar um backend separado do frontend, sua função é criar, editar, deletar e listar tarefas.

## Como rodar o projeto:
Clone o projeto:
> ```bash
> git clone https://github.com/eduardocamiloo/api_gerenciador_tarefas.git
> ```

Instale as dependências:
> ```bash
> composer install
> ```

Crie um arquivo .env baseado no .env.example e insira seus dados:
> ```bash
> cp .env.example .env
> ```

Rode as migrations:
> ```bash
> vendor/bin/phinx migrate
> ```




