# 🐾 PetShop

Sistema web para gerenciamento de um pet shop, desenvolvido com PHP, PostgreSQL, HTML e CSS.

O projeto permite cadastrar e consultar pets, visualizar serviços, agendar banhos e outros atendimentos, consultar produtos e brinquedos e utilizar um carrinho de compras.

## Sumário

1. Sobre o projeto
2. Requisitos funcionais
3. Regras de negócio
4. Requisitos não funcionais
5. Fluxo de trabalho
6. Banco de dados
7. Organização do código
8. Como rodar

---

## 1. Sobre o projeto

O **PetShop** é um sistema desenvolvido para facilitar o gerenciamento de informações dos animais, dos serviços oferecidos e dos produtos disponíveis em uma loja para pets.

O sistema utiliza PHP para processar as informações, PostgreSQL para armazenar os dados e HTML e CSS para construir as páginas.

### Principais funcionalidades

- Cadastro de pets com informações do animal e de seu responsável.
- Consulta dos pets e dos banhos agendados.
- Edição e exclusão de registros de agendamento.
- Visualização dos serviços oferecidos pelo pet shop.
- Agendamento de serviços, como banho, banho e tosa, tosa e hidratação.
- Cadastro e consulta de produtos e brinquedos.
- Upload de imagens de pets e produtos.
- Login, cadastro de usuários e encerramento da sessão.
- Carrinho de compras com cálculo do total e finalização da compra.
- Atualização do estoque após a finalização da compra.

### Tecnologias utilizadas

| Tecnologia | Utilização |
|---|---|
| PHP | Processamento dos formulários, sessões e regras do sistema |
| PostgreSQL | Armazenamento dos dados |
| HTML5 | Estrutura das páginas |
| CSS3 | Aparência e organização visual |
| Git e GitHub | Versionamento e armazenamento do projeto |

---

## 2. Requisitos funcionais

| Código | Requisito | Arquivos relacionados |
|---|---|---|
| RF01 | Exibir a página inicial do pet shop. | `index.php` |
| RF02 | Cadastrar informações de pets. | `app/create.php` |
| RF03 | Consultar os pets e os dados dos banhos agendados. | `app/select.php` |
| RF04 | Consultar um pet pelo identificador. | `app/select_w.php` |
| RF05 | Editar e excluir registros de pets e agendamentos. | `app/update.php`, `app/delete.php` |
| RF06 | Exibir os serviços oferecidos pelo pet shop. | `servicos/select.php` |
| RF07 | Agendar serviços informando pet, responsável, serviço, data e horário. | `agenda/create.php` |
| RF08 | Consultar os agendamentos realizados. | `agenda/select.php` |
| RF09 | Cadastrar produtos com nome, categoria, preço, estoque e imagem. | `app/produto_create.php` |
| RF10 | Consultar os produtos e seus dados. | `app/produto_select.php`, `produtos/select.php` |
| RF11 | Editar informações de produtos cadastrados. | Arquivos de atualização de produtos |
| RF12 | Adicionar produtos ao carrinho e remover itens. | `app/carrinho.php` |
| RF13 | Calcular o subtotal e o valor total do carrinho. | `app/carrinho.php` |
| RF14 | Finalizar uma compra e atualizar o estoque dos produtos. | `app/carrinho.php` |
| RF15 | Realizar login e cadastro de usuários. | `login/login.php`, `login/cadastra.php` |
| RF16 | Encerrar a sessão do usuário. | `login/logout.php` |

*Observação: os nomes e caminhos de alguns arquivos podem variar conforme a versão do projeto. O requisito RF11 deve ser conferido com o arquivo de atualização de produtos presente no repositório.*

---

## 3. Regras de negócio

| Código | Regra |
|---|---|
| RN01 | Para acessar as páginas protegidas, o usuário precisa estar autenticado. |
| RN02 | O cadastro de pets deve receber as informações solicitadas no formulário. |
| RN03 | Não é permitido agendar um banho em uma data passada. |
| RN04 | Um horário já ocupado não pode ser utilizado para outro agendamento de banho. |
| RN05 | Os agendamentos podem ser consultados e alterados pelas páginas correspondentes. |
| RN06 | Os produtos possuem nome, categoria, preço e quantidade em estoque. |
| RN07 | O cadastro de produtos permite enviar uma imagem. |
| RN08 | O carrinho só adiciona produtos que existem e possuem estoque disponível. |
| RN09 | Ao adicionar novamente um produto ao carrinho, sua quantidade aumenta. |
| RN10 | A compra precisa ter itens para ser finalizada. |
| RN11 | O estoque deve ser verificado antes de concluir uma compra. |
| RN12 | A quantidade comprada é descontada do estoque após a conclusão da compra. |
| RN13 | Os dados das compras e de seus itens são registrados no banco de dados. |
| RN14 | O usuário pode encerrar a sessão pelo link de saída. |

---

## 4. Requisitos não funcionais

| Código | Categoria | Requisito |
|---|---|---|
| RNF01 | Compatibilidade | Utilizar PHP com suporte ao PostgreSQL. |
| RNF02 | Banco de dados | Manter os dados persistidos no PostgreSQL. |
| RNF03 | Usabilidade | Disponibilizar formulários para cadastro e consulta de informações. |
| RNF04 | Organização | Separar os arquivos por áreas, como login, agenda, produtos e serviços. |
| RNF05 | Interface | Utilizar HTML e CSS para estruturar e estilizar as páginas. |
| RNF06 | Segurança | Utilizar consultas parametrizadas para os dados enviados ao banco, mantendo esse padrão em todas as operações. |
| RNF07 | Segurança | Proteger páginas restritas e validar as permissões no servidor. |
| RNF08 | Integridade | Verificar os dados e o estoque antes de registrar uma compra. |
| RNF09 | Manutenção | Manter os arquivos organizados para facilitar alterações futuras. |

---

## 5. Fluxo de trabalho

### 5.1. Cadastro e consulta de pets

```text
Página inicial
      |
      v
Cadastrar pet
      |
      v
Preencher formulário
      |
      v
Salvar no PostgreSQL
      |
      v
Consultar os registros
      |
      +----> Editar
      |
      +----> Excluir
```

### 5.2. Agendamento de serviços

```text
Página de serviços
      |
      v
Escolher o serviço
      |
      v
Informar pet, responsável,
data e horário
      |
      v
Verificar disponibilidade
      |
      v
Registrar o agendamento
      |
      v
Consultar a agenda
```

### 5.3. Produtos e compras

```text
Consultar produtos
      |
      v
Adicionar ao carrinho
      |
      v
Verificar quantidade e preço
      |
      v
Conferir o estoque
      |
      v
Finalizar a compra
      |
      v
Registrar a compra
      |
      v
Atualizar o estoque
```

### 5.4. Login

```text
Tela de login
      |
      v
Informar e-mail e senha
      |
      v
Verificar os dados
      |
      +----> Dados incorretos: exibir mensagem
      |
      +----> Dados corretos: iniciar sessão
                         |
                         v
                    Página inicial
```

---

## 6. Banco de dados

O sistema utiliza o PostgreSQL e realiza a conexão por meio do arquivo `database/connect.php`.

As tabelas utilizadas pelas operações do projeto incluem:

| Tabela | Finalidade |
|---|---|
| `usuarios` | Armazenar os dados das contas de usuários. |
| `pets` | Armazenar informações dos animais, responsáveis e agendamentos de banho. |
| `agenda` | Registrar os agendamentos de serviços. |
| `produtos` | Armazenar nome, categoria, preço, estoque e imagem dos produtos. |
| `compras` | Registrar as compras realizadas. |
| `itens_compra` | Armazenar os produtos, quantidades e preços de cada compra. |

### Conexão com o banco

O arquivo `database/connect.php` configura a conexão entre o PHP e o PostgreSQL.

Antes de executar o projeto, é necessário:

1. Instalar e iniciar o PostgreSQL.
2. Criar o banco de dados `petshop`.
3. Criar as tabelas necessárias para o funcionamento do sistema.
4. Configurar a conexão no arquivo `database/connect.php`.

**Importante:** utilize suas próprias credenciais de banco de dados e não publique senhas no GitHub.

---

## 7. Organização do código

A estrutura principal do repositório está organizada da seguinte maneira:

```text
projeto_integrador_petshop/
│
├── agenda/
│   ├── create.php
│   ├── select.php
│   └── arquivos de atualização e exclusão
│
├── app/
│   ├── create.php
│   ├── select.php
│   ├── select_w.php
│   ├── update.php
│   ├── delete.php
│   ├── produto_create.php
│   ├── produto_select.php
│   └── carrinho.php
│
├── database/
│   └── connect.php
│
├── img/
│   └── imagens utilizadas pelo projeto
│
├── login/
│   ├── login.php
│   ├── cadastra.php
│   ├── logout.php
│   └── verifica_user.php
│
├── produtos/
│   ├── select.php
│   └── arquivos relacionados aos produtos
│
├── servicos/
│   └── select.php
│
├── style/
│   └── style.css
│
├── uploads/
│   ├── pets/
│   └── produtos/
│
└── index.php
```

*Os diretórios e arquivos de atualização, exclusão e imagens devem corresponder aos existentes na versão instalada do projeto.*

### Responsabilidade de cada pasta

- **`agenda/`**: cadastro e consulta de agendamentos.
- **`app/`**: operações de cadastro, consulta, atualização e exclusão, além de funcionalidades de produtos e carrinho.
- **`database/`**: conexão com o PostgreSQL.
- **`img/`**: imagens utilizadas na interface.
- **`login/`**: autenticação, cadastro de usuários, encerramento e verificação de sessão.
- **`produtos/`**: páginas relacionadas à consulta de produtos.
- **`servicos/`**: apresentação dos serviços oferecidos.
- **`style/`**: arquivo CSS responsável pela aparência das páginas.
- **`uploads/`**: imagens enviadas pelos formulários.
- **`index.php`**: página inicial e navegação principal.

---

## 8. Como rodar

### 8.1. Pré-requisitos

Antes de começar, instale:

- Git;
- PHP com a extensão `pgsql`;
- PostgreSQL;
- Um navegador, como Google Chrome ou Microsoft Edge.

O XAMPP pode ser utilizado para executar o PHP e o Apache no Windows, desde que a extensão necessária para o PostgreSQL esteja habilitada.

### 8.2. Baixar o projeto

Abra o terminal do VS Code e execute:

```bash
git clone https://github.com/MayaraZigart/projeto_integrador_petshop.git
```

Entre na pasta do projeto:

```bash
cd petshop
```

### 8.3. Criar o banco de dados

Abra o PostgreSQL pelo pgAdmin ou pelo terminal e crie o banco:

```sql
CREATE DATABASE petshop;
```

Depois, crie as tabelas utilizadas pelo sistema. Os nomes e campos devem corresponder às consultas dos arquivos PHP.

### 8.4. Configurar a conexão

Abra o arquivo:

```text
database/connect.php
```

Configure o endereço do servidor, a porta, o nome do banco, o usuário e a senha do PostgreSQL.

Não envie senhas reais para o repositório público.

### 8.5. Iniciar o projeto

No terminal, dentro da pasta do projeto, execute:

```bash
php -S localhost:8000
```

Abra o navegador e acesse:

```text
http://localhost:8000
```

Mantenha o terminal aberto enquanto utiliza o site. Para interromper o servidor, pressione `Ctrl + C`.

### 8.6. Verificar o funcionamento

Após iniciar o projeto, confira:

- A página inicial abre corretamente.
- O login e o cadastro funcionam.
- Os formulários conseguem salvar e consultar informações.
- Os serviços e agendamentos são exibidos.
- Os produtos aparecem com seus dados.
- O carrinho calcula os valores e a compra atualiza o estoque.

Se alguma função apresentar erro, confira a conexão com o PostgreSQL, a existência das tabelas e os caminhos dos arquivos.

---

## Considerações finais

O projeto **PetShop** reúne funcionalidades de cadastro e gerenciamento de pets, agendamento de serviços e controle de produtos e compras. Ele foi desenvolvido como projeto integrador para praticar PHP, banco de dados PostgreSQL, HTML, CSS e organização de aplicações web.
