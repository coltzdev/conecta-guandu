# Conecta Guandu

O Conecta Guandu é uma plataforma web desenvolvida para facilitar a divulgação e a busca por profissionais autônomos de Baixo Guandu - ES.

O projeto permite que moradores encontrem profissionais por serviço ou profissão, consultem informações sobre o atendimento e acessem as formas de contato disponibilizadas em cada perfil.

## Funcionalidades

- Busca de profissionais por nome, serviço ou profissão.
- Filtro por profissão.
- Organização das profissões em categorias.
- Listagem de profissionais cadastrados.
- Página individual de cada profissional.
- Exibição dos serviços oferecidos.
- Exibição das formas de atendimento.
- Exibição dos horários de atendimento.
- Contato por WhatsApp, telefone ou Instagram, quando disponível.
- Exibição de portfólio quando cadastrado.
- Interface responsiva para diferentes tamanhos de tela.

## Tecnologias utilizadas

- HTML5
- CSS3
- JavaScript
- PHP
- MySQL
- Bootstrap

## Banco de dados

A versão acadêmica implementada utiliza 7 tabelas:

- `categorias`
- `profissoes`
- `profissionais`
- `servicos_oferecidos`
- `formas_atendimento`
- `horarios_atendimento`
- `portfolio`

O arquivo `database/conecta_guandu.sql` cria o banco de dados, as tabelas e os relacionamentos necessários, além de inserir as 7 categorias e as 25 profissões utilizadas pela plataforma.

Os cadastros dos profissionais não fazem parte desse script público e devem ser inseridos posteriormente no banco de dados.

## Configuração local

### 1. Banco de dados

Execute o arquivo `database/conecta_guandu.sql` em uma instalação do MySQL.

O banco criado será `conecta_guandu`.

### 2. Configuração da conexão

Na pasta `includes` existe o arquivo `config.example.php`.

Crie uma cópia desse arquivo com o nome `config.local.php` e informe os dados da sua instalação do MySQL.

Exemplo:

```php
<?php

return [
    'host' => 'localhost',
    'porta' => '3306',
    'banco' => 'conecta_guandu',
    'usuario' => 'root',
    'senha' => ''
];
```

O arquivo `config.local.php` está incluído no `.gitignore` para evitar que credenciais locais sejam enviadas ao repositório.

### 3. Servidor local

Coloque a pasta do projeto dentro do diretório `htdocs` do XAMPP.

Inicie o Apache pelo XAMPP e mantenha o MySQL em execução.

Depois, acesse o projeto pelo navegador utilizando o endereço correspondente ao nome da pasta dentro de `htdocs`.

Exemplo, caso a pasta se chame `plataforma`:

`http://localhost/plataforma/`

## Estrutura principal

```text
plataforma/
├── assets/
│   ├── css/
│   ├── fonts/
│   ├── icons/
│   ├── img/
│   └── js/
├── database/
│   └── conecta_guandu.sql
├── includes/
│   ├── config.example.php
│   ├── conexao.php
│   ├── footer.php
│   └── navbar.php
├── index.php
├── profissionais.php
├── profissional.php
├── quem-somos.php
├── .gitignore
└── README.md
```

## Contexto do projeto

O Conecta Guandu foi desenvolvido como projeto acadêmico com aplicação voltada à comunidade de Baixo Guandu - ES.

A versão atual concentra-se na consulta pública dos profissionais e de suas informações.

O cadastro administrativo de profissionais não faz parte do escopo implementado nesta versão.