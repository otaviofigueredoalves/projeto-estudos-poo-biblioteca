<?php
namespace App\BibliotecaPoo\Entidades;
use App\BibliotecaPoo\traits\Logger;

abstract class Usuario
{
    use Logger;

    public function __construct(private string $nome, private int $id = 0){}
    
    public function getNome()
    {
        return $this->nome;
    }
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
}