<?php
namespace App\BibliotecaPoo;

use App\BibliotecaPoo\traits\Logger; // pra usar a trait preciso importar o namespace onde ela está

class EstanteEstudos
{
    use Logger;
    
    private array $livros = []; // Não é necessário constructor pois este array não é algo que receberemos na instância, ele já possui valor inicial. Aqui sempre será vazio, mas se fossemos conectar em um DB, esse valor atualizaria de acordo com o que está no banco de dados.

    public function adicionarLivro(Livro $livro) // Pra adicionar o livro a gente precisa dele. Então, a função espera como parâmetro uma instância pronta do tipo Livro (DI - acoplamento fraco)
    {
        if(!in_array($livro, $this->livros, true)){ // o parâmetro true para SÓ disparar que o livro já foi adicionado se for a MESMA instância
            $this->livros[] = $livro;
            $this->log("O livro {$livro->getTitulo()} foi adicionado!<br>");
        } else {
            $this->log("O livro {$livro->getTitulo()} já foi adicionado!<br>");
        }
    }

    public function removerLivro(Livro $livro)
    {
        // if (in_array($livro, $this->livros)){
        //     $indice = array_search($livro, $this->livros, true); // pega o indice do livro atual, EXATAMENTE ELE, por conta do terceiro parâmetro
        //     unset($this->livros[$indice]);
        //     $this->livros = array_values($this->livros);
        //     $this->log("O Livro {$livro->getTitulo()} foi removido!");
        // } else {
        //     $this->log("Este livro não existe!");
        // }
        $this->log("Livro atual: {$livro->getTitulo()}");
        // assim

        // com condicional pra verificar se já existe. SOLUÇÃO NÃO OTIMIZADA
        // if(in_array($livro, $this->livros)){
        //     $this->livros = array_filter($this->livros, fn($livroAtual) => $livroAtual !== $livro);
        //     $this->livros = array_values($this->livros);
        // } else {
        //     $this->log("LIVRO NÃO EXISTE");
        // }

        $totalAntes = count($this->livros);
        $this->livros = array_filter($this->livros, fn($livroAtual) => $livroAtual !== $livro);
        $totalDepois = count($this->livros);

        if($totalAntes > $totalDepois){
            $this->livros = array_values($this->livros);
            $this->log("O LIVRO {$livro->getTitulo()} FOI REMOVIDO");
        } else {
            $this->log("ESTE LIVRO NÃO ESTÁ CADASTRADO NA BIBLIOTECA!");
        }

        // ou assim
        // $this->livros = array_filter($this->livros, 
        //     fn($livroAtual) => $livroAtual !== $livro
        // );
        // $this->livros = array_values($this->livros);
        
        
        
    }
}
