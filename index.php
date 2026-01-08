<?php
ini_set('display_errors', 1);
require_once 'vendor/autoload.php';

use \App\BibliotecaPoo\entidades\Livro;
use \App\BibliotecaPoo\repositories\LivroRepository;
use \App\BibliotecaPoo\entidades\Editora;
use \App\BibliotecaPoo\entidades\Categoria;
use \App\BibliotecaPoo\Entidades\Aluno;
use \App\BibliotecaPoo\Entidades\Professor;
use \App\BibliotecaPoo\Entidades\Visitante;
use \App\BibliotecaPoo\Entidades\Bibliotecario;
use \App\BibliotecaPoo\db\Connection;

// conexão DB
$pdo = Connection::startConnection();

// #1 LIVRO - CADASTRO
try{

    $repository_livro = new LivroRepository($pdo);
    $editora = $repository_livro->buscarEditora('Anto');
    $categoria = $repository_livro->buscarCategoria('Ht');

    $livro = new Livro("A metamorfose",['Franz Kafka'],$editora, $categoria);
    // var_dump($categoria);
    
} catch (Exception $e){
    echo "Erro com livro: ". $e->getMessage();
}

// Editora

try {

} catch (PDOException $e){
    echo "Erro com editora: ". $e->getMessage();
}

// Categoria

try {
    $categoria = new Categoria(0,'Technologia');
    $categoriaCadastro = new LivroRepository($pdo);
    // $categoriaCadastro->adicionarCategoria($categoria);

} catch (PDOException){
     echo "Erro com categoria: ". $e->getMessage();
}

// #2 ESTANTE
try{
    $estante = new LivroRepository($pdo);
    $estante->adicionarLivro($livro);
    // $resultado = $estante->buscarLivroPorTitulo('IT');
    // echo "<pre>";
    // var_dump($resultado);

    // $estante->atualizarNomeLivro($livro1, 'Coisas óbvias sobre o amor');
    // $livros = $estante->listarLivrosDisponiveis();
    // echo "<pre>";
    // foreach ($livros as $livro){
    //     print_r($livro->nome);
    //     echo "<br>";
    // }
 
    // var_dump($resultado);
    // $estante->removerLivro($livro2);    
    // $estante->removerLivro($livro1);
 
} catch (PDOException $e){
    echo "ERRO GRAVE NO BANCO: ".$e->getMessage();
}

// #3 ALUNO

// #3.1 PROFESSOR


// #3.2 VISITANTE

// #4 Bibliotecário
