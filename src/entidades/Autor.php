<?php
namespace App\BibliotecaPoo\entidades;

class Autor
{
    public function __construct(private string $nome)
    {}

    public function getNome()
    {
        return $this->nome;
    }

    public function adicionarAutor()
    {

    }

   
}