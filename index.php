<?php
ini_set('display_errors', 1);
require_once 'vendor/autoload.php';

use \App\BibliotecaPoo\entidades\Livro;
use \App\BibliotecaPoo\repositories\EstanteRepository;
use \App\BibliotecaPoo\Entidades\Aluno;
use \App\BibliotecaPoo\Entidades\Professor;
use \App\BibliotecaPoo\Entidades\Visitante;
use \App\BibliotecaPoo\Entidades\Bibliotecario;
use \App\BibliotecaPoo\db\Connection;
$pdo = Connection::startConnection();

// #1 LIVRO
try{
    $livro1 = new Livro('A Metamorfose',['Franz Kafka','Elayne Baeta']);
    $livro2 = new Livro('IT A coisa',['Stephen King']);
} catch (Exception $e){
    echo "Erro: ". $e->getMessage();
}

// #2 ESTANTE
try{
    $estante = new EstanteRepository($pdo);
    // $estante->adicionarLivro($livro2);
    // $resultado = $estante->buscarLivroPorTitulo('IT');
    // var_dump($resultado);

    // $estante->atualizarNomeLivro($livro1, 'Coisas óbvias sobre o amor');
    // $livros = $estante->listarLivrosDisponiveis();
    // echo "<pre>";
    // foreach ($livros as $livro){
    //     print_r($livro->nome);
    //     echo "<br>";
    // }
 
    // var_dump($resultado);
    // $estante->removerLivro($livro1);
    
    // $estante->removerLivro($livro1);
 
} catch (PDOException $e){
    echo "ERRO GRAVE NO BANCO: ".$e->getMessage();
}

// #3 ALUNO

// #3.1 PROFESSOR


// #3.2 VISITANTE

// #4 Bibliotecário
