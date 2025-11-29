<?php
namespace App\ProjetoBiblioteca\Controllers;

use App\ProjetoBiblioteca\Models\Produto;

class ProdutoController
{
    private Produto $produto;

    public function __construct()
    {
        $this->produto = new Produto();
    }

    public function mostrarProduto()
    {
        echo 'O produto é: '. $this->produto->getNome() . "<br>";
    }
}