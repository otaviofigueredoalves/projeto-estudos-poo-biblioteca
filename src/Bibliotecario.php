<?php
namespace App\BibliotecaPoo;

use App\BibliotecaPoo\traits\Logger;
use Exception;

class Bibliotecario
{
    use Logger;
    public function emprestarLivro(Usuario $usuario, Livro $livro, Estante $estante )
    {
        if(!$usuario->podePegarEmprestado()){
            $this->log("NÃO PODE PEGAR EMPRESTADO");
            return false;
        }

        if(!$estante->buscarLivroPorTitulo($livro->getTitulo())){
            $this->log("{$livro->getTitulo()} NÃO ESTÁ NA ESTANTE!");
            return false;
        }

        try {
            $livro->marcarEmprestado();
            $estante->removerLivro($livro);
            $usuario->adicionarLivroEmprestado($livro);
            $this->log("SUCESSO: Livro '{$livro->getTitulo()}' emprestado para {$usuario->getNome()}.");
        } catch (Exception $e){
            $this->log("FALHA: ".$e->getMessage());
            return false;
        }

        
    }
}