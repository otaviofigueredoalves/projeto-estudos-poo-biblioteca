<?php

namespace App\BibliotecaPoo\repositories;

use App\BibliotecaPoo\entidades\Usuario;
use App\BibliotecaPoo\entidades\Aluno;
use App\BibliotecaPoo\traits\Logger;
use App\BibliotecaPoo\entidades\Professor;
use PDO;
use Exception;
use PDOException;

class UserRepository
{
   public function __construct(private PDO $pdo) {}
   use Logger;

   public function adicionarUsuario(Usuario $user)
   {
      try {

         if ($user instanceof Aluno) {
            $query = "INSERT INTO Aluno (
            nome 
            ) VALUES (
            :nome
            )";
         }
         if ($user instanceof Professor) {
            $query = "INSERT INTO Professor (
            nome 
            ) VALUES (
            :nome 
            )";
         }

         $this->pdo->beginTransaction();
         $stmt = $this->pdo->prepare($query);
         $stmt->bindValue(':nome', $user->getNome());
         if ($stmt->execute()) {
            $this->log("Query executada");
         } else {
            throw new PDOException("Erro ao executar a query");
         }
         if ($this->pdo->commit()) {
            $this->log("O usuario {$user->getNome()} foi cadastrado");
         } else {
            throw new Exception("Usuário já cadastrado!");
         }
      } catch (PDOException $e) {
         $this->log("Erro ao executar o método! " . $e->getMessage());
         $this->pdo->rollBack();
      }
   }

   public function buscarUsuarioPorNome(string $user, string $cargo): ?Array
    {
          try {
            $user = "%{$user}%";
            /** Aqui estava com dúvida na sintaxe, pra interligar livro com autor a gente usa a tabela livro_autor, ok, entendi isso, mas e a sintaxe da query? Manter em mente: Qualquer condicional só vem depois dos JOINS
             * 
             */
            if($cargo == 'professor'){
               $query = "SELECT * FROM Professor WHERE Nome LIKE :nome";
            } else if ($cargo == 'aluno'){
               $query = "SELECT * FROM Aluno WHERE Nome LIKE :nome";
            } else {
               throw new Exception("CARGO INVÁLIDO!");
            }

            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':nome', $user);
            if ($stmt->execute()) {
                $this->log("Realizando busca");
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                // var_dump($data[0]['id_livro']);

                if(!empty($data)){
                  $users = [];
                  if($cargo == 'professor'){
                     foreach ($data as $user){
                        $users[] = new Professor($user['nome'],$user['id_professor']);
                     }
                  } else if($cargo == 'aluno'){
                     foreach ($data as $user){
                        $users[] = new Aluno($user['nome'],$user['id_aluno']);
                     }
                  }
                  
                  return $users;
                } else {
                  throw new Exception("Usuário não encontrado!");
                }
               
            } else {
                throw new Exception("Não foi possível conectar ao banco");
            }
        } catch (Exception $e) {
            $this->log("FALHA: " . $e->getMessage());
            return null;
        }
        return null;
    }

    public function removerUsuario(string $user, string $cargo)
    {
        try{
           $this->pdo->beginTransaction();
            $usuario = $this->buscarUsuarioPorNome($user, $cargo);
            if(!empty($usuario)){
               $usuario_nome = $usuario[0]->getNome();
            } else {
               throw new Exception("USUÁRIO NÃO EXISTE NO BANCO!");
            }
            
            echo '<pre>';
            print_r($usuario_nome);

            if($cargo == 'professor'){
               $query = "DELETE FROM Professor WHERE nome = :nome";
            } else if($cargo == 'aluno'){
               $query = "DELETE FROM Aluno WHERE nome = :nome";
            }

            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(":nome",$usuario_nome);
            if($stmt->execute()){
               $this->log("USUÁRIO $usuario_nome DELETADO!");
               $this->pdo->commit();
            } else {
               throw new PDOException("Erro ao executar a query");
            }

        } catch (Exception $e){
            $this->log("FALHA: ". $e->getMessage());
            $this->pdo->rollBack();
        }
    }

     public function atualizarNomeUsuario(Usuario $user, string $nome)
    {
        $this->pdo->beginTransaction();
        $user_id = $user->getId();
        if($user instanceof Aluno){
            $query = "UPDATE Aluno SET 
                  nome = :nome
                  WHERE id_aluno = :id";
        } else if($user instanceof Professor){
            $query = "UPDATE Professor SET 
                  nome = :nome
                  WHERE id_professor = :id";
        }
        

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':id', $user_id);

        if ($stmt->execute()) {
            $this->log("Aluno atualizado!");
            $this->pdo->commit();
        } else {
            throw new Exception("Erro ao executar query no banco");
        }
       
    }
}


