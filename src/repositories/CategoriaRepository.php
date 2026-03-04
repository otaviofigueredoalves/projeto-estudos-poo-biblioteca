<?php
namespace App\BibliotecaPoo\repositories;
use App\BibliotecaPoo\entidades\Categoria;
use App\BibliotecaPoo\traits\Logger;
use PDO;
use PDOException;

class CategoriaRepository{
    use Logger;
    public function __construct(private PDO $pdo)
    {}
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
}