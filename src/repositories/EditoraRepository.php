<?php

namespace App\BibliotecaPoo\repositories;

use App\BibliotecaPoo\entidades\Editora;
use App\BibliotecaPoo\traits\Logger;
use PDO;
use PDOException;

class EditoraRepository
{
    use Logger;
    public function __construct(private PDO $pdo) {}
    
    public function adicionarEditora(Editora $editora)
    {
        try {
            $this->pdo->beginTransaction();
            $query = "INSERT INTO Editora (nome) VALUES (:nome)";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':nome', $editora->getNome());

            if ($stmt->execute()) {
                $this->log("Query rodou!");
                $this->log("Editora cadastrada com sucesso!");
            }

            $this->pdo->commit();
        } catch (PDOException $e) {
            echo "Erro ao cadastrar a editora";
            $this->log($e->getMessage());
        }
    }

    public function buscarEditora(string $titulo): ?Object
    {
        $editora = '';
        $titulo = "%$titulo%";
        $query = "SELECT * FROM Editora WHERE nome LIKE :nome";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':nome', $titulo);

        if ($stmt->execute()) {
            $this->log("REALIZANDO BUSCA");
            $editora = $stmt->fetch(PDO::FETCH_OBJ);
            // var_dump($editora);
            if (!empty($editora)) {
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
}
