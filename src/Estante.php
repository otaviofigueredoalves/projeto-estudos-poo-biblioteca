<?php

namespace App\BibliotecaPoo;

use App\BibliotecaPoo\traits\Logger;

class Estante
{
    private array $livros = [];

    use Logger;

    public function adicionarLivro(Livro $livro)
    {
        $this->livros[] = $livro;
        $this->log("O LIVRO {$livro->getTitulo()} FOI ADICIONADO A ESTANTE!");
        $livro->marcarDisponivel();
    }

    public function removerLivro(Livro $livro)
    {
        $qtdAntes = count($this->livros);
        $this->livros = array_filter($this->livros, fn($livroAtual) => $livroAtual !== $livro);
        $qtdDepois = count($this->livros);

        if($qtdAntes > $qtdDepois){
            $this->livros = array_values($this->livros);
            $this->log("O LIVRO {$livro->getTitulo()} FOI REMOVIDO!");
        } else {
            throw new \Exception("ESTE LIVRO NÃO EXISTE NA ESTANTE!");
        }
    }

    public function buscarLivroPorTitulo(string $titulo) : ?Array
    {
        $livrosListados = [];
        foreach($this->livros as $livro){
            if(str_contains(strtolower($livro->getTitulo()), strtolower($titulo))){
                $livrosListados[] = $livro;
            }
        }
        if(empty($livrosListados)){
            throw new \Exception("NENHUM LIVRO ENCONTRADO!");
            return null;
        }
        return $livrosListados;
    }

    public function listarLivrosDisponiveis():?Array
    {
        return $this->livros = array_filter($this->livros, fn($livroAtual) => $livroAtual->estaDisponivel() === true);
    }
}