<?php

namespace src\services;

use Exception;
use src\Dao\SaidaDao;
use src\Dao\ProdutoDao;
use src\model\SaidaProduto;

class SaidaService {

    private SaidaDao $saidaDao;
    private ProdutoDao $produtoDao;

    public function __construct(SaidaProduto $saidaDao, ProdutoDao $produtoDao)
    {
        $this->saidaDao = $saidaDao;
        $this->produtoDao = $produtoDao;
    }

    public function criarEntrada(SaidaProduto $entradaProduto){
        $produto = $this->produtoDao->encontrarPorID($entradaProduto->id_produto);
        if(!isset($produto)){
            return throw new Exception("Produto nao existe");
        }
        
        if($entradaProduto->quantidade < 0 ){
            return throw new Exception("Quantidade deve ser maior que 0");
        }
        
        $this->saidaDao->saidaDeProduto($entradaProduto);
        $removerQuantidade = $entradaProduto->quantidade - $produto->quantidade;
        $produto->quatidade = $removerQuantidade;
        $this->produtoDao->editar($produto);

    }


}