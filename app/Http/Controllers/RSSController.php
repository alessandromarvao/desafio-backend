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
     */
    private $isEmpty = true;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        try {
            // Carrega o arquivo RSS e converte para xml. A constante LIBXML_NOCDATA é utilizada para montar os dados inclusos nas tags do RSS protegidos com a tag <![CDATA] ...>
            $this->itens = simplexml_load_file(env('RSS_URL'),  null, LIBXML_NOCDATA);

            if (count($this->itens->channel->item) > 0) {
                $this->isEmpty = false;
            }
        } catch (Throwable $e) {
            echo "Erro: " . $e;
        }
    }

    public function index()
    {
        $arrayTitle = [];

        if (!$this->isEmpty) {
            foreach ($this->itens->channel->item as $itens) {
                $arrayBreakLine = ["\n ", " \n"];

                array_push($arrayTitle, str_replace($arrayBreakLine, "", $itens->title));
            }

            $itens = [
                'quantidade' => count($arrayTitle),
                'noticias' => $arrayTitle
            ];
            return json_encode(['data' => $itens]);
        } else {
            return null;
        }
    }

    public function show($tag)
    {
        $arrayTitle = [];

        if (!$this->isEmpty) {
            foreach ($this->itens->channel->item as $itens) {
                // print_r((string) $itens->category . "<br/>");        
                $arrayBreakLine = ["\n ", " \n"];
                if (strcmp($itens->category, $tag) == 0)
                    array_push($arrayTitle, str_replace($arrayBreakLine, "", $itens->title));
            }

            $itens = [
                'quantidade' => count($arrayTitle),
                'noticias' => $arrayTitle
            ];
            return json_encode(['data' => $itens]);
        } else {
            return null;
        }
    }
}
