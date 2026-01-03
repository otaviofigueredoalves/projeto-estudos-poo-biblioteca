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
use App\BibliotecaPoo\db\connection;
use PDO;

use Exception;
use PDOException;

class EstanteRepository
{
    

    public function __construct(private PDO $pdo)
    {}

    use Logger;
    public function adicionarLivro(Livro $livro)
    {
        try{
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

            $id_editora = $livro->getEditora();
            $id_categoria = $livro->getCategoria();

            $stmt = $this->pdo->prepare($query_insert);
            $stmt->bindParam(':id_editora', $id_editora);
            $stmt->bindParam(':id_categoria', $id_categoria);
            $stmt->bindParam(':nome', $livro->getTitulo());
            
            if($stmt->execute()){
                $this->log("Livro {$livro->getTitulo()}");
                $id = $this->pdo->lastInsertId();
                $this->setIdLivro($id, $livro);

                $autores = $livro->getAutor();

                if($autores){
                    
                    foreach($autores as $autor){
                        $query = "INSERT INTO Autor (nome) VALUES (:nome)";
                        $stmt = $this->pdo->prepare($query);
                        $nome_autor = $autor;
                        $stmt->bindParam(':nome',$nome_autor);
                        
                        $stmt->execute();
                        $id_autor = $this->pdo->lastInsertId();

                        $query = "INSERT INTO livro_autor (id_livro,id_autor) VALUES (:id_livro, :id_autor)";
                        $stmt = $this->pdo->prepare($query);

                        // // var_dump($id);
                        $stmt->bindValue(':id_livro', $id);
                        $stmt->bindValue(':id_autor',$id_autor);
                        
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
            $this->pdo->commit();
            $this->log("Livro adicionado na estante");
            
        } catch (PDOException $e){
            echo "Erro ao tentar adicionar o livro!";
            $this->log($e->getMessage());
            $this->pdo->rollBack();
        }
    
    }

  
    public function buscarLivroPorTitulo(string $titulo) : ?Array
    {
        try{
            $titulo = "%{$titulo}%";
            $query = "SELECT * FROM Livro WHERE nome LIKE :titulo";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':titulo',$titulo);
            if($stmt->execute()){
                $this->log("Realizando busca");
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
             
                return $data;

            } else {
                throw new Exception("Não foi possível conectar ao banco");
            }
            
        } catch (Exception $e) {
            $this->log("FALHA: ".$e->getMessage());
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
        try{
          $this->pdo->beginTransaction();
          $id = $livro->getId();
          $query = "DELETE FROM Livro WHERE id_livro = :id";
          $stmt  = $this->pdo->prepare($query);
          $stmt->bindValue(':id',$id);

          if($stmt->execute()){
            if($stmt->rowCount() > 0){
                $titulo = $livro->getTitulo();
                $this->log("O livro $titulo foi deletado!");
            } else {
                throw new Exception("Nenhum livro foi deletado!");
            }

          } else {
            throw new Exception("Não foi possível remover o livro");
          }
          $this->pdo->commit();

        } catch (PDOException $e){
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
        $stmt->bindValue(':nome',$nome);
        $stmt->bindValue(':id',$id);
        
        if($stmt->execute()){
            $this->log("Livro atualizado!");
        } else {
            throw new Exception("Erro ao executar query no banco");
        }
        $this->pdo->commit();
    }
    
    public function listarLivrosDisponiveis():?Array
    {
        $query_busca = 'SELECT * FROM Livro';
        $stmt = $this->pdo->prepare($query_busca);
        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        return $data;
    }
}