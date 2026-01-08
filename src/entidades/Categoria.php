<?php
namespace App\BibliotecaPoo\entidades;

class Categoria
{
    public function __construct(private int $id_categoria, private string $nome)
    {}

   
   public function getId()
   {
        return $this->id_categoria;
   }

   public function getNome()
   {
        return $this->nome; 
   }
}