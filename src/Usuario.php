<?php
namespace App\BibliotecaPoo;
use App\BibliotecaPoo\traits\Logger;

abstract class Usuario
{
    use Logger;

    protected array $livrosEmprestados = [];

    public function __construct(private string $nome){}

    abstract function podePegarEmprestado():bool;
    
    public function adicionarLivroEmprestado(Livro $livro): void
    {
        $this->livrosEmprestados[] = $livro;
    }

    public function removerLivroEmprestado(Livro $livro): void
    {
        $this->livrosEmprestados = array_filter($this->livrosEmprestados, fn($livroAtual) => $livroAtual !== $livro);
    }

    public function listarLivrosEmprestados()
    {
        return $this->livrosEmprestados;
    }

    public function getNome()
    {
        return $this->nome;
    }
}