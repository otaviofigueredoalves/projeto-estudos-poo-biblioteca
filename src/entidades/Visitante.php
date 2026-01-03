<?php
namespace App\BibliotecaPoo\Entidades;

class Visitante extends Usuario
{
    public function podePegarEmprestado(): bool
    {
        $this->log("O Visitante {$this->getNome()} NÃO pode pegar livros emprestados");
        return false;
    }
}