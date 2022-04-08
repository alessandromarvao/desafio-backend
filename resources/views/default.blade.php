<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Notívias</title>
    <link rel="stylesheet" href="css/app.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <h1>CWorks</h1>
        <h3>Teste de admissão</h3>
        <small>Alessandro Marvão</small>
    </header>
    <main>
        <section>
            <div>
                <h2>Notícias do dia:</h2>
                <div id="total"></div>
            </div>
            <ul id='noticias'></ul>
        </section>
        <aside>
            <h3>Categorias:</h3>
            <ul id="categorias"></ul>
        </aside>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let response = [];

        /**
         * Método que recebe os dados do servidor quando a página é carregada
         */
        $.getJSON('/rss', function(resultado) {
            // recebe todos os valores do RSS
            response = resultado;
            $("#categorias").append('<li onclick="loadTag(\'\')">Todas as anotícias</li>');

            $("#total").html('Total: ' + resultado['quantidade'])
            // console.log(resultado['data']['noticias']);
            $.each(resultado['noticias'], function(i, item) {
                $("#noticias").append('<li>' + item + "</li>")
            })
            $.each(resultado['categoria'], function(i, item) {
                $("#categorias").append('<li onclick="loadTag(\'' + item + '\')">' + item + "</li>")
            })
        });

        // Função que carrega as notícias de acordo com as categorias selecionadas (ou todas as notícias)
        function loadTag(tag) {
            // Limpa os dados da lista desordenada (`ul`) das notícias
            $("#noticias").html('');

            if (tag === "") { // se não houver nenhuma categoria selecionada, carrega todas as notícias...
                changeNews(response);
            } else { // ... se não, carrega as notícias relacionadas à categoria selecionada
                $.ajax({ // método de requisição assíncrona com o servidor (sufixo da url: /tag/`categoria selecionada`)
                    method: 'GET',
                    url: '/tag/' + tag,
                    dataType: 'JSON'

                }).done(function(resultado) {
                    changeNews(resultado);
                })
            }
        }

        // Função que armazena os dados das notícias nos campos notícia e quantidade
        function changeNews(array) {
            $("#total").html('Total: ' + array['quantidade']);
            
            $.each(array['noticias'], function(i, item) {
                $("#noticias").append('<li>' + item + "</li>")
            })
        }
    </script>
</body>

</html>