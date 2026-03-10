<?php
namespace App\BibliotecaPoo\Entidades;

use App\BibliotecaPoo\traits\Logger;
use App\BibliotecaPoo\repositories\LivroRepository;
use App\BibliotecaPoo\repositories\UserRepository;
use PDO;
use Exception;

class EmprestimoService
{
    use Logger;

    public function __construct(private UserRepository $userRepo, private LivroRepository $livroRepo, PDO $pdo)
    {
        throw new \Exception('Not implemented');
    }

    public function emprestarLivro()
    {

    }
    
}