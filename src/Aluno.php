<?php

namespace App\BibliotecaPoo;

class Aluno extends Usuario
{
    private const MAX_LIVROS_EMPRESTADOS = 1;
    
    public function podePegarEmprestado(): bool
    {
        $qtdLivros = count($this->livrosEmprestados);
        $qtdTotal = self::MAX_LIVROS_EMPRESTADOS - $qtdLivros;
        $status = $qtdLivros < self::MAX_LIVROS_EMPRESTADOS;
        $concat = "";

        if($qtdTotal > 1){
            $concat = "s";
        }

        if($status){
            $this->log("O Aluno {$this->getNome()} pode pegar $qtdTotal livro". $concat ."!");
            return $status;
        }
        $this->log("O Aluno {$this->getNome()} NÃO pode mais pegar livros. Limite máximo: ".self::MAX_LIVROS_EMPRESTADOS);
        return $status;


    }
}