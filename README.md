# DLStore

Loja virtual demonstrativa de equipamentos de informática, com catálogo, busca, carrinho, cadastro e checkout. Projeto acadêmico do curso Técnico em Informática, posteriormente reformulado com tema azul-escuro e melhorias no fluxo de compra.

**Autor:** [Daniel Faria](https://github.com/danielfaria31) · [LinkedIn](https://www.linkedin.com/in/daniel-lutz-santoro-de-faria-406143291/)

## O que dá para testar

- Catálogo por categoria e busca por nome ou descrição.
- Página de produto com ampliação de imagem e parcelas demonstrativas.
- Carrinho com quantidades, remoção e resumo do pedido.
- Cadastro e login; senhas armazenadas com `password_hash`.
- Endereço validado no servidor e confirmação de pedido com transação no banco.
- Layout responsivo em HTML, CSS e JavaScript, sem framework de interface.

Pagamentos e frete são **simulações**. A aplicação não cobra, não envia produtos e não solicita dados de cartão. Use somente dados fictícios.

## Tecnologias e organização

PHP 8.0 ou superior, extensão MySQLi com mysqlnd e MySQL/MariaDB. A versão local foi testada com PHP 8.0.30 e MariaDB do XAMPP; para novas instalações, prefira uma versão de PHP ainda mantida.

A arquitetura atual usa páginas PHP e funções compartilhadas. **Não é uma implementação completa de MVC ou de orientação a objetos.** Não há Composer ou dependências JavaScript para instalar.

```text
public/       Páginas e arquivos acessíveis pelo navegador
src/          Layout, funções compartilhadas e conexão
config/       Exemplo de configuração; arquivo local ignorado pelo Git
database/    Esquema limpo e catálogo de demonstração
tests/       Verificação do fluxo HTTP
docs/        Limitações, decisões e origem dos recursos
```

## Executar localmente

1. Instale PHP com MySQLi e inicie MySQL/MariaDB (XAMPP também funciona).
2. Crie um banco **vazio** chamado `dlstore`, com `utf8mb4`.
3. Importe `database/schema.sql` nesse banco, usando phpMyAdmin ou o cliente MySQL. O arquivo cria tabelas; não deve ser importado sobre um banco existente.
4. Copie `config/database.example.php` para `config/database.local.php` e ajuste host, porta, banco, usuário e senha. Esse arquivo não entra no Git.
5. Na raiz do projeto, execute:

```sh
php -S 127.0.0.1:8080 -t public
```

Abra [a loja local](http://127.0.0.1:8080). O servidor embutido é apenas para desenvolvimento. A pasta pública deve ser **somente `public/`**, para não servir configurações e SQL.

Alternativamente, configure `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER` e `DB_PASSWORD` no ambiente; eles têm prioridade sobre o arquivo local.

Não há conta administrativa nem usuário de demonstração pré-cadastrado. Crie sua conta pela interface com dados fictícios.

## Verificar

```sh
python tests/smoke.py http://127.0.0.1:8080
```

O teste usa apenas a biblioteca padrão do Python 3. Ele cria uma conta fictícia e um pedido; execute **somente em banco descartável de desenvolvimento**. Confira também [o roteiro visual](docs/VALIDACAO.md).

O GitHub Actions verifica a sintaxe PHP e executa esse teste em um banco limpo.

## Escopo e próximos passos

A versão deste repositório contém o fluxo de compra reformulado. O painel administrativo antigo e páginas experimentais foram excluídos desta distribuição, pois precisam de revisão própria. O original permanece separado.

Antes de transformar em loja real: implementar gateway de pagamentos, frete real, controle de estoque concorrente, proteção contra tentativas repetidas de login, recuperação de senha e revisão de segurança completa. Validação atual de CPF verifica somente o formato de 11 dígitos, não titularidade ou dígitos verificadores.

As fotos e marcas vieram do arquivo acadêmico original. Consulte [origem e direitos](docs/RECURSOS.md); nenhuma licença de terceiros é presumida. Não foi adicionada uma licença de redistribuição em seu nome.


