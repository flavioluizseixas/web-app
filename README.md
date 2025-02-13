# Projeto: Cadastro de Clientes com Consulta de Endereço

## Objetivo
Desenvolver uma aplicação web para cadastro de clientes, incluindo a consulta automática de endereços por meio da API dos Correios. O projeto visa exercitar habilidades em desenvolvimento backend e frontend, além da integração com APIs externas.

---

## Requisitos

### 1. Backend
- Desenvolver uma **API REST** para gerenciar os cadastros de clientes.
- Permitir as seguintes operações:
  - Criar um novo cliente (**nome, CPF, endereço**).
  - Listar todos os clientes cadastrados.
  - Consultar um cliente específico pelo **CPF**.
  - Atualizar informações de um cliente.
  - Remover um cliente do sistema.
- Implementar a **consulta automática de endereços** ao informar o **CEP**, utilizando a **API dos Correios** (ou [ViaCEP](https://viacep.com.br/) como alternativa).
- Utilizar um dos seguintes frameworks:
  - **PHP**: Laravel, Lumen, Symphony, ...
  - **JavaScript/TypeScript**: Fastify, Express, NestJS, ...
  - **Python**: FastAPI, Flask, ...
- Armazenamento dos dados em um **banco de dados relacional** (**MySQL, PostgreSQL ou SQLite**).
- Utilizar um **ORM** conforme o framework escolhido:
  - **Eloquent** (Laravel),
  - **Prisma/TypeORM** (Node.js),
  - **SQLAlchemy** (Python).

### 2. Frontend
- Criar uma **interface web** para interação com o sistema.
- Implementar as seguintes funcionalidades:
  - **Formulário de cadastro** de cliente, com validação dos campos.
  - Campo de **CEP** com consulta automática à **API dos Correios** para preenchimento dos campos de endereço.
  - **Tabela** para exibição da lista de clientes cadastrados.
  - Funcionalidades de **edição e remoção** de clientes.
- Utilizar um dos frameworks:
  - **React, Angular ou Vue.js**.
- Comunicação com o backend via requisições HTTP (**Axios, Fetch API**).

---

## Critérios de Avaliação
- **Organização do Código**: Uso de boas práticas de programação, separação adequada de responsabilidades e estrutura modular.
- **Funcionamento da API**: Todas as operações **CRUD** devem estar funcionando corretamente.
- **Integração com API Externa**: A consulta de endereço pelo **CEP** deve ser realizada automaticamente.
- **Interface Usuário**: A interface deve ser responsiva, intuitiva e funcional.
- **Persistência de Dados**: O banco de dados deve armazenar corretamente as informações dos clientes.

---

## Entrega
- Disponibilizar o código-fonte em um **repositório GitHub**.
- Documentar o projeto com **instruções de instalação e uso** (`README.md`).
- Demonstrar o funcionamento com um pequeno **vídeo ou screenshots**.
