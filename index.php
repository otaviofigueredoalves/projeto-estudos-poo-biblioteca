<?php
require_once 'vendor/autoload.php';

use \App\BibliotecaPoo\Livro;
use \App\BibliotecaPoo\Estante;
use \App\BibliotecaPoo\Aluno;
use \App\BibliotecaPoo\Professor;
use \App\BibliotecaPoo\Visitante;
use \App\BibliotecaPoo\Bibliotecario;

// #1 LIVRO
$livro1 = new Livro("Metamorfose","Franz Kafka");
$livro5 = new Livro("A origem das espécies","Charles Darwin");
$livro2 = new Livro("1984","George Orwell");
$livro3 = new Livro("Dom Casmurro","Machado de Assis");
$livro4 = new Livro("O amor não é óbvio","Elayne Baeta");

// #2 ESTANTE
$estante = new Estante();
$estante->adicionarLivro($livro1);

// #3 ALUNO
$aluno1 = new Aluno("Aluno 1");
$aluno2 = new Aluno("Aluno 2");

// #3.1 PROFESSOR
$professor = new Professor("Professor 1");

// #3.2 VISITANTE
$visitante = new Visitante("Visitante 1");

// #4 Bibliotecário
$bibliotecario = new Bibliotecario();
$bibliotecario->emprestarLivro($aluno1, $livro1, $estante);
echo "<hr>";
$bibliotecario->emprestarLivro($aluno2, $livro1, $estante);


// $estante = new Estante();
// echo "<pre>";
// $estante->adicionarLivro($livro1);
// $estante->adicionarLivro($livro2);
// $estante->adicionarLivro($livro3);
// $estante->adicionarLivro($livro4);
// // $estante->removerLivro($livro4);

// // var_dump($estante->buscarLivroPorTitulo("meta"));
// // print_r( $estante->listarLivrosDisponiveis());
// // $livro4->marcarDisponivel();
// // print_r( $estante->listarLivrosDisponiveis());
// // $estante->removerLivro($livro4);
// // var_dump($estante);

// // ALUNO
// $aluno1= new Aluno("Otavio");
// $aluno1->podePegarEmprestado();
// $aluno1->adicionarLivroEmprestado($livro1);
// $aluno1->podePegarEmprestado();

// // PROFESSOR
// $professor = new Professor("Wesley");
// $professor->podePegarEmprestado();
// $professor->adicionarLivroEmprestado($livro1);
// $professor->podePegarEmprestado();
// $professor->adicionarLivroEmprestado($livro1);
// $professor->podePegarEmprestado();
// $professor->adicionarLivroEmprestado($livro1);
// $professor->podePegarEmprestado();

// // VISITANTE
// $visitante = new Visitante("Default");
// $visitante->podePegarEmprestado();
