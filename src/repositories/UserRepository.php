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
            $this->pdo->rollBack();
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

   // public function buscarUsuarioPorNome(): ?Object
   //  {
   //       // esse método é peculiar pois no momento está recebendo uma string, mas, pensei o seguinte. Se eu for manter dessa forma, ele não vai saber se estou procurando um aluno ou um professor e aí ou eu teria que mudar o parâmetro para receber uma instancia do tipo usuario. Ou, eu crio dois métodos que fazem a mesma coisa e só mudam a query. A terceira opção é passar um novo parâmetro que recebe ou um objeto ou um cargo. Mas esse cargo seria via string? Não parece muito certo, e se for booleano, se limitaria a apenas duas opções
   //  }
}


