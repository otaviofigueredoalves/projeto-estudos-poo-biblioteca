<?php
namespace App\BibliotecaPoo;
use App\BibliotecaPoo\traits\Logger;

class UsuarioEstudos
{
    use Logger;

    private array $livrosEmprestados = []; // definimos um array vazio como padrão para definir que inicialmente todo usuário não possui nenhum livro emprestado

    public function __construct(private string $nome, private string $tipo = 'aluno'){} // aqui definimos que a classe vai receber o nome e o TIPO do aluno através da instância. Vai funcionar, mas futuramente se precisar de mais uma feature será necessário modificara o código da classe UsuarioEstudos

    public function podePegarEmprestado():bool
    {
        $qtdLivros = count($this->livrosEmprestados); // armazena os items do array
        $podePegar = $qtdLivros < 3 && strtolower($this->tipo) === 'professor' || $qtdLivros < 1 && strtolower($this->tipo) === 'aluno'; // faz a verificação de tipo já na classe pai
        if($podePegar){ // deixa no plural ou no singular 
            $qtdTotal = 3 - $qtdLivros;
            $concat = "";

            if($qtdTotal > 1){
                $concat = "s";
            }

            $this->log("O usuário {$this->nome} pode pegar $qtdTotal livro". $concat ."!");
        } else {
            $this->log("O usuário {$this->nome} não pode pegar um livro!");
        }
        return $podePegar;
    }

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
}