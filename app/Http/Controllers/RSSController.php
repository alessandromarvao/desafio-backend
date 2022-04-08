<?php

namespace App\Http\Controllers;

use Throwable;

class RSSController extends Controller
{
    /**
     * Recebe os itens da RSS
     * 
     * @param array
     */
    private $itens = [];

    /**
     * Variável que verifica se o array contém os valores da RSS
     * 
     * @param bool Retorna `true` se o array contém os valores da RSS e `false` se o array estiver vazio 
     */
    private $isEmpty = true;

    /**
     * Cria uma nova instância deste `Controller`
     *
     * @return void
     */
    public function __construct()
    {
        try {
            // Carrega o arquivo RSS e converte para xml. A constante LIBXML_NOCDATA é utilizada para montar os dados inclusos nas tags do RSS protegidos com a tag <![CDATA] ...>
            // $this->itens = simplexml_load_file(env('RSS_URL'),  null, LIBXML_NOCDATA);
            $this->itens = simplexml_load_file('lixo/arquivo.rss',  null, LIBXML_NOCDATA); // Arquivo que baixei da RSS para teste direto, sem necesidade de testar com internet

            // Verifica se a quantidade dos elementos do array recebido é maior que 0. Se sim, muda a variável `isEmpty` para verdadeiro
            if (count($this->itens->channel->item) > 0) {
                $this->isEmpty = false;
            }
        } catch (Throwable $e) { 
            print "Erro: " . $e; // Retorna uma mensagem de erro para o cliente
        }
    }

    /**
     * Percorre todo o array recebido do RSS e armazena o título, categoria e quantidade de elementos (notícias) no formato JSON
     * 
     * @return string JSON
     */
    public function index()
    {
        $arrayTitle = []; // Array que receberá os títulos das notícias
        $arrayTags = []; // Array que receberá as categorias das notícias

        if (!$this->isEmpty) {
            //Percorre todo o array para trabalhar com os itens individualmente
            foreach ($this->itens->channel->item as $item) {
                // Array contendo as quebras de linhas no início e no final de cada elemento. (Ex.: \n Esportes \n)
                $arrayBreakLine = ["\n ", " \n"];

                //Recebe os valores das categorias
                $tag =  str_replace($arrayBreakLine, "", $item->category);

                // Armazena os título já corrigidos com a substituição das quebras de linhas na variável $arrayTitle
                array_push($arrayTitle, str_replace($arrayBreakLine, "", $item->title));

                // Evita a repetição das categorias para a exibição na `view`
                if (!in_array($tag, $arrayTags)) {
                    array_push($arrayTags, $tag); // Se a categoria atual ainda não pertence à variável $arrayTags, o armazena.
                }
            }

            // Variável que monta o array para a entrega no formato JSON
            $itens = [
                'quantidade' => count($arrayTitle),
                'noticias' => $arrayTitle,
                'categoria' => str_replace(".", ",", $arrayTags) // As categorias que contêm ponto (.) apresentaram erro na rota do Laravel (e.c. Bahia deu erro 404 - Not Found), então substituí o ponto por vírgula
            ];

            // Codifica o array para o formato JSON e devolve para o cliente
            return json_encode($itens);
        } else {
            //Retorna `null` se 
            return null;
        }
    }

    /**
     * Percorre o array recebido a partir da pesquisa por categoria e armazena o título, categoria e quantidade de elementos (notícias) no formato JSON
     * 
     * @return string JSON
     */
    public function show($tag)
    {
        // Array que receberá os títulos das notícias
        $arrayTitle = []; 

        // Recebe a categoria escolhida pelo cliente, se a categoria tinha ponto antes de ser enviada ao cliente, substitui a vírgula pelo ponto (.)
        $tag = str_replace("%20", " ", str_replace(",", ".", $tag));

        // Confere se o array dos elementos não está vazio
        if (!$this->isEmpty) {
            // percorre todos os elementos do array individualmente
            foreach ($this->itens->channel->item as $item) {
                $arrayBreakLine = ["\n ", " \n"];

                // Verifica se a categoria atual do array é a categoria escolhida pelo cliente. Se sim, armazena os dados da notícia no array
                if (str_contains($item->category, $tag)) {
                    array_push($arrayTitle, str_replace($arrayBreakLine, "", $item->title));
                }
            }


            // Variável que monta o array para a entrega no formato JSON
            $itens = [
                'quantidade' => count($arrayTitle),
                'noticias' => $arrayTitle
            ];

            // Codifica o array para o formato JSON e devolve para o cliente
            return json_encode($itens);
        } else {
            return null;
        };
    }
}
