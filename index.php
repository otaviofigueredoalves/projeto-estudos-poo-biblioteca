<?php
ini_set('display_errors', 1);
require_once 'vendor/autoload.php';

use \App\BibliotecaPoo\entidades\Livro;
use \App\BibliotecaPoo\repositories\LivroRepository;
use \App\BibliotecaPoo\entidades\Editora;
use \App\BibliotecaPoo\entidades\Categoria;
use \App\BibliotecaPoo\entidades\Aluno;
use \App\BibliotecaPoo\Entidades\Professor;
use \App\BibliotecaPoo\Entidades\Visitante;
use \App\BibliotecaPoo\Entidades\Bibliotecario;
use \App\BibliotecaPoo\db\Connection;
use App\BibliotecaPoo\repositories\EditoraRepository;
use App\BibliotecaPoo\repositories\CategoriaRepository;
use App\BibliotecaPoo\repositories\UserRepository;

// conexão DB
$pdo = Connection::startConnection();

// #1 LIVRO - CADASTRO
try{

    // $repository_livro = new LivroRepository($pdo);
    // $repository_editora = new EditoraRepository($pdo);
    // $repository_categoria = new CategoriaRepository($pdo);

    // $editora = $repository_editora->buscarEditora('Anto');
    // $categoria = $repository_categoria->buscarCategoria('HTML');
    
    // $livro = new Livro("Fly to the moon",['Frank Sinatra'],$editora, $categoria);
    // // var_dump($categoria);
    
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
    // $estante->adicionarLivro($livro);
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

// $aluno1 = new Aluno("Ketley");
// $aluno2 = new Aluno("Ketley Linhares");
// #3 ALUNO
$userRepository = new UserRepository($pdo);
// $userRepository->adicionarUsuario($aluno1);
// $userRepository->adicionarUsuario($aluno2);
$lista = $userRepository->buscarUsuarioPorNome('Ketley','aluno');
echo "<pre>";
var_dump($lista);
// $aluno1 = new Aluno("Otávio");
// $userRepository->adicionarUsuario($aluno1);


// #3.1 PROFESSOR


// #3.2 VISITANTE

// #4 Bibliotecário
