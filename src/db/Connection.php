<?php
namespace App\BibliotecaPoo\db;
use PDO, PDOException;


class Connection
{
    
    public static function startConnection(): PDO
    {
        $dsn = 'mysql:host=localhost;dbname=biblioteca;charset=utf8mb4';
        $user = 'root';
        $pwd = 'admin';


        try {
            $pdo = new PDO($dsn, $user, $pwd);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo 'Conexão bem sucedida';
            echo "<hr>";
            return $pdo;
        } catch (PDOException $e){
            echo "Erro ao conectar no banco: ";
            die($e->getMessage());
        }
    }
}
