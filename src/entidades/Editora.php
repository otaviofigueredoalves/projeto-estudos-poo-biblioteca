<?php
namespace App\BibliotecaPoo\entidades;

class Editora
{
    public function __construct(private int $id_editora, private string $nome)
    {}
}