<?php
namespace App\BibliotecaPoo\Entidades;

use App\BibliotecaPoo\traits\Logger;
use App\BibliotecaPoo\repositories\EstanteRepository;

use Exception;

class Bibliotecario
{
    use Logger;
    public static function emprestarLivro(Usuario $usuario, Livro $livro, EstanteRepository $estante)
    {
        if(!$usuario->podePegarEmprestado()){
            self::log("NÃO PODE PEGAR EMPRESTADO");
            return false;
        }

        if(!$estante->buscarLivroPorTitulo($livro->getTitulo())){
            self::log("{$livro->getTitulo()} NÃO ESTÁ NA ESTANTE!");
            return false;
        }

        try {
            $livro->marcarEmprestado();
            $estante->removerLivro($livro);
            $usuario->adicionarLivroEmprestado($livro);
            self::log("SUCESSO: Livro '{$livro->getTitulo()}' emprestado para {$usuario->getNome()}.");
        } catch (Exception $e){
            self::log("FALHA: ".$e->getMessage());
            return false;
        }
    }

    public static function devolverLivro(Usuario $usuario, Livro $livro, EstanteRepository $estante){
        try{
            if(!in_array($livro, $usuario->listarLivrosEmprestados())){
                throw new \Exception("{$usuario->getNome()} NÃO ESTÁ COM O LIVRO!");
            }
            $usuario->removerLivroEmprestado($livro);
            $estante->adicionarLivro($livro);
            $livro->marcarDisponivel();
            self::log("O livro {$livro->getTitulo()} foi DEVOLVIDO");
        } catch (Exception $e){
            self::log("FALHA: ".$e->getMessage());
        }
        
    }
}