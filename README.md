# Convergence Works
Aplicação de teste da Convergence Works, que recebe uma fonte de dados RSS [https://www.correio24horas.com.br/rss/] e exibe um relatório com a quantidade e os títulos das notícias.

### Metodologia utilizada:
A aplicação foi desenvolvida com Lumen (versão 7.4) tanto para o processamento do lado servidor (back-end), quando para a exibição dos dados coletados para o cliente (front-end).

Também utilizei a framework JQuery para realizar as requisições assíncronas (AJAX) com o servidor, de modo a manter todas as informações necessárias apenas em uma única página.

#### Laravel Lumen
Lumen é um micro-framework derivado do Laravel, que possui as mesmas funções do Laravel, porém com recursos limitados, tornando-a mais leve e rápida. O Lumen é mais utilizado para criação de microsserviços e API's.

Para o desenvolvimento desta aplicação, só precisei criar apenas 3 rotas:

1 - [Página principal](https://cw-test-alessandro-marvao.herokuapp.com/), 

2 - [Arquivo JSON com todas as notícias do dia](https://cw-test-alessandro-marvao.herokuapp.com/rss);

3 - [Arquivo JSON com as notícias escolhidas por categoria)](https://cw-test-alessandro-marvao.herokuapp.com/tag/{categoria}).

Dessa forma não é necessário utilizar todos ou a maioria dos recursos nativos do Laravel.

## Instalação:
Para a instalação em sua máquina local, você deverá possuir instalado PHP versão 7 e [Composer](https://getcomposer.org/).

1. Você pode fazer o download deste repositório ou cloná-lo a partir do GitHub:

```bash
git clone https://github.com/alessandromarvao/desafio-backend.git
```

2. Concluído o download/clone, você deverá renomear o arquivo ".env.example" para ".env".

3. Ainda no arquivo ".env", você deverá atribuir um valor para a constante APP_KEY, que recebe uma string (length) de 32 caracteres (que você pode gerar acessando [este site](http://www.unit-conversion.info/texttools/random-string-generator/)). 

```
APP_KEY=digite-aqui-sua-string
```
4. Com o terminal (ou prompt de comando) aberto na pasta raiz do projeto, você deverá baixar as dependências do projeto via composer:

```bash
composer install
```

```bash
composer install --no-scripts
```

5. Ainda no prompt de comando aberto na pasta raiz do projeto, execute o comando para executar a aplicação no seu computador:

```bash
php -S localhost:8000 -t public
```

6. Agora você pode abrir o navegador e acessar o link (localhost:8000) que já estará acessando a aplicação.

Esta aplicação também está implantada no [Heroku](https://cw-test-alessandro-marvao.herokuapp.com/).

Quaisquer dúvidas ou sugestões, por favor encaminhar para meu endereço de e-mail (alessandromarvao@gmail.com).
