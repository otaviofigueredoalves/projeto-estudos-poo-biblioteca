<?php
namespace App\ProjetoBiblioteca\Models;
class Produto
{
    public function __construct()
    {
        echo "Eu sou um produto" . "<br>";
    }

    public function getNome()
    {
        return "XBOX";
    }
}