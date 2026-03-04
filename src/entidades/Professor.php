<?php

namespace App\BibliotecaPoo\Entidades;

class Professor extends Usuario
{
    public function podePegarEmprestado($count): bool
    {
        if($count > 4){
            return false;
        }
        return true;
    }
}