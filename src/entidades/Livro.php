<?php
namespace App\BibliotecaPoo\Entidades;

class Livro // Será o primeiro objeto a ser construído, já que todo o sistema é feito para a gestão deste objeto;
{
    /**
     * O disponível nós colocamos com valor, fazemos isso para aumentar a segurança em todo o processo, o livro só deve ser disponibilizado se ele existir, se ele for falso por natureza há mais controle na hora da distribuição, marcando como disponivel. É a justificativa que eu pensei pra colocar disponivel como false, em vez de true. Além disso, é necessário definir um valor inicial para essa propriedade bool, pois ela não depende de um dado externo, ou seja, quando eu instancio uma classe o livro é CRIADO, não faz sentido eu passar o status do livro logo em sua criação pois ainda será decidido o que será feito com ele.
     */
   
    public function __construct(
        private string $titulo, 
        private array $autores = [],
        private int $id_editora = 1, 
        private int $id_categoria = 1, 
        private bool $disponivel = false,
        private int $id = 0,
        ) 
    {}

    public function estaDisponivel()
    {
        return $this->disponivel;
    }

    // setter
    public function marcarDisponivel()
    {
        $this->disponivel = true;
    }

    // setter
    public function marcarEmprestado()
    {
        if($this->disponivel == true){
            $this->disponivel = false;
        } else {
            throw new \Exception("Livro indisponível");
        }
    }

    // setter
    public function setId($id)
    {
        $this->id = $id;
    }

    // getter
    public function getTitulo()
    {
        return $this->titulo;
    }

    // getter
    public function getAutor()
    {
        return $this->autores;
    }

    public function getEditora(){

        return $this->id_editora;
    }

    public function getCategoria()
    {
        return $this->id_categoria;
    }

    public function getId()
    {
        return $this->id;
    }
}