<?php

/**
 * CRUD CHECK LIST
 * 
 * CREATE -> adicionarLivro()
 * READ -> buscarLivroPorTitulo();
 * UPDATE -> atualizarLivro();
 * DELETE -> removerLivro();
 */

namespace App\BibliotecaPoo\repositories;

use App\BibliotecaPoo\traits\Logger;
use App\BibliotecaPoo\Entidades\Livro;
use App\BibliotecaPoo\entidades\Editora;
use App\BibliotecaPoo\db\connection;
use App\BibliotecaPoo\entidades\Categoria;
use ArrayAccess;
use PDO;

use Exception;
use PDOException;

class LivroRepository
{


    public function __construct(private PDO $pdo) {}

    use Logger;
    public function adicionarLivro(Livro $livro)
    {
        try {
            $this->pdo->beginTransaction();
            $query_insert = 'INSERT INTO Livro (
                id_editora,
                id_categoria,
                nome
            ) VALUES (
                :id_editora,
                :id_categoria,
                :nome
            );';

            $id_editora = $livro->getIdEdit();
            $id_categoria = $livro->getIdCtg();

            $stmt = $this->pdo->prepare($query_insert);
            $stmt->bindParam(':id_editora', $id_editora);
            $stmt->bindParam(':id_categoria', $id_categoria);
            $stmt->bindValue(':nome', $livro->getTitulo());

            if ($stmt->execute()) {
                $this->log("Livro {$livro->getTitulo()}");
                $id = $this->pdo->lastInsertId();
                $this->setIdLivro($id, $livro);

                $autores = $livro->getAutor();

                if ($autores) {

                    foreach ($autores as $autor) {
                        $query = "INSERT INTO Autor (nome) VALUES (:nome)";
                        $stmt = $this->pdo->prepare($query);
                        $nome_autor = $autor;
                        $stmt->bindParam(':nome', $nome_autor);

                        $stmt->execute();
                        $id_autor = $this->pdo->lastInsertId();

                        $query = "INSERT INTO livro_autor (id_livro,id_autor) VALUES (:id_livro, :id_autor)";
                        $stmt = $this->pdo->prepare($query);

                        // // var_dump($id);
                        $stmt->bindValue(':id_livro', $id);
                        $stmt->bindValue(':id_autor', $id_autor);

                        // $this->log("ID DO LIVRO: $id");
                        // $this->log("NOME: $nome_autor");
                        // $this->log("ID DO AUTOR: $id_autor");

                        $stmt->execute();
                        $this->log("$autor adicionado!");
                    }
                    // $stmt->execute();


                } else {
                    throw new Exception("Nenhum autor cadastrado!");
                    $this->pdo->rollBack();
                }
            }
            // $this->pdo->commit();
            $this->log("Livro adicionado na estante");
        } catch (PDOException $e) {
            echo "Erro ao tentar adicionar o livro!";
            $this->log($e->getMessage());
            $this->pdo->rollBack();
        }
    }

    public function adicionarEditora(Editora $editora)
    {
        try{
            $this->pdo->beginTransaction();
            $query = "INSERT INTO Editora (nome) VALUES (:nome)";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':nome', $editora->getNome());
            
            if($stmt->execute()){
                $this->log("Query rodou!");
                $this->log("Editora cadastrada com sucesso!");
            } 

            $this->pdo->commit();
        } catch (PDOException $e){
            echo "Erro ao cadastrar a editora";
            $this->log($e->getMessage());
        }
    }

    public function buscarEditora(string $titulo) :?Object
    {
        $editora = '';
        $titulo = "%$titulo%";
        $query = "SELECT * FROM Editora WHERE nome LIKE :nome";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':nome',$titulo);

        if($stmt->execute()){
            $this->log("REALIZANDO BUSCA");
            $editora = $stmt->fetch(PDO::FETCH_OBJ);
            // var_dump($editora);
            if(!empty($editora)){
                // var_dump($editora);
                $editora = new Editora($editora->id_editora, $editora->nome);
                $this->log("Editora encontrada!");
                return $editora;
                // print_r($editora);
            } else {
                throw new PDOException("Nenhuma editora encontrada!");
            }

            return null;
        } else {
            throw new PDOException("Erro na busca!");
        }
    }

    public function buscarCategoria(string $titulo) :?Object
    {
        $categoria = '';
        $titulo = "%$titulo%";
        $query = "SELECT * FROM Categoria WHERE nome LIKE :nome";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':nome',$titulo);

        if($stmt->execute()){
            $this->log("REALIZANDO BUSCA");
            $categoria = $stmt->fetch(PDO::FETCH_OBJ);
            if(!empty($categoria)){
                // var_dump($editora);
                $categoria = new Categoria($categoria->id_categoria, $categoria->nome);
                $this->log("Categoria encontrada!");
                return $categoria;
            } else {
                throw new PDOException("Nenhuma editora encontrada!");
            }

            return null;
        } else {
            throw new PDOException("Erro na busca!");
        }
    }

    public function adicionarCategoria(Categoria $categoria)
    {
        try{
            $this->pdo->beginTransaction();
            $query = "INSERT INTO Categoria (nome) VALUES (:nome)";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':nome', $categoria->getNome());
            
            if($stmt->execute()){
                $this->log("Query rodou!");
                $this->log("Categoria cadastrada com sucesso!");
            } 

            $this->pdo->commit();
        } catch (PDOException $e){
            echo "Erro ao cadastrar a categoria";
            $this->log($e->getMessage());
        }
        
    }

    public function buscarLivroPorTitulo(string $titulo): ?Object
    {
        try {
            $titulo = "%{$titulo}%";
            /** Aqui estava com dúvida na sintaxe, pra interligar livro com autor a gente usa a tabela livro_autor, ok, entendi isso, mas e a sintaxe da query? Manter em mente: Qualquer condicional só vem depois dos JOINS
             * 
             */
            $query = "SELECT Livro.*, Autor.nome AS nome_autor FROM Livro
            INNER JOIN livro_autor ON livro_autor.id_livro = Livro.id_livro
            INNER JOIN Autor ON livro_autor.id_autor = Autor.id_autor
            WHERE Livro.nome LIKE :titulo
            ";

            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':titulo', $titulo);
            if ($stmt->execute()) {
                $this->log("Realizando busca");
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                // var_dump($data[0]['id_livro']);


                if (!empty($data)) {
                    $id_livro = $data[0]['id_livro'];
                    $id_categoria = $data[0]['id_categoria'];
                    $id_editora = $data[0]['id_editora'];
                    $nome_livro = $data[0]['nome'];
                    $nome_autor = [];
                    foreach ($data as $livro) {
                        $nome_autor[] = $livro['nome_autor'];
                    }
                } else {
                    throw new Exception("Nenhum livro encontrado");
                }



                $livro = new Livro($nome_livro, $nome_autor, $id_editora, $id_categoria, $id_livro);

                return $livro;
            } else {
                throw new Exception("Não foi possível conectar ao banco");
            }
        } catch (Exception $e) {
            $this->log("FALHA: " . $e->getMessage());
            return null;
        }
        return null;
    }

    public function setIdLivro($id, Livro $livro)
    {
        $livro->setId($id);
    }

    public function removerLivro(Livro $livro)
    {
        try {
            $this->pdo->beginTransaction();
            $livro = $this->buscarLivroPorTitulo($livro->getTitulo());
            //   var_dump($livro);

            if (!empty($livro)) {
                $query = "DELETE FROM livro_autor WHERE id_livro = :id";
                $stmt = $this->pdo->prepare($query);
                $stmt->bindValue(':id', $livro->getId());

                if ($stmt->execute()) {
                    $query = "DELETE FROM Livro WHERE id_livro = :id";
                    $stmt = $this->pdo->prepare($query);
                    $stmt->bindValue(':id', $livro->getId());
                    $stmt->execute();
                    $this->log("LIVRO {$livro->getTitulo()} DELETADO COM SUCESSO!");
                    $this->pdo->commit();
                    return true;
                }
                throw new PDOException("Não foi possível deletar o livro!");
            } else {
                throw new PDOException("Registro de chave estrangeira não foi deletado! ");
            }
            
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            echo "Erro brutal";
            $this->log($e->getMessage());
        }
    }

    public function atualizarNomeLivro(Livro $livro, string $nome)
    {
        $id = $livro->getId();
        $query = "UPDATE Livro SET 
                  nome = :nome
                  WHERE id_livro = :id";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':id', $id);

        if ($stmt->execute()) {
            $this->log("Livro atualizado!");
        } else {
            throw new Exception("Erro ao executar query no banco");
        }
        $this->pdo->commit();
    }

    public function listarLivrosDisponiveis(): ?array
    {
        $query_busca = 'SELECT * FROM Livro';
        $stmt = $this->pdo->prepare($query_busca);
        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }
}
