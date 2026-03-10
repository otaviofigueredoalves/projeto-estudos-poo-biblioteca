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
use App\BibliotecaPoo\entidades\Categoria;
use App\BibliotecaPoo\entidades\Usuario;
use PDO;
use Exception;
use PDOException;

class EmprestimoRepository
{
    public function __construct(private PDO $pdo) {}

    use Logger;

    public function emprestarLivro(Livro $livro, Usuario $user)
    {
        if($livro->estaDisponivel() && $user->)
    }


}
