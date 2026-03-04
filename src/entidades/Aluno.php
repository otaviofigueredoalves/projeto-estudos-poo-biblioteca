<?php

namespace App\BibliotecaPoo\entidades;

class Aluno extends Usuario
{
    public function podePegarEmprestado($count): bool
    {
        if($count > 2){
            return false;
        }
        return true;
    }
}