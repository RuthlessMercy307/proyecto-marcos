# Pizzaria Santa Gula

Este projeto contém um site simples de vendas de pizzas feito em PHP, JavaScript e MySQL.

## Configuração do Banco de Dados

1. Crie um banco de dados MySQL executando o script `proyecto/usr.sql`.
2. O script cria as tabelas de usuários, redefinição de senha e produtos, além de um usuário administrador (login `admin` senha `admin`).
3. Edite `conexao.php` caso seus dados de acesso ao MySQL sejam diferentes.

## Funcionalidades

- Registro e login de usuários.
- Recuperação de senha por token.
- Página de pedidos com carrinho e busca de produtos.
- Área administrativa para cadastro de produtos.

Após importar o banco e subir os arquivos em um servidor com PHP, acesse `login_index.php` para entrar ou `register_index.php` para criar uma conta.
