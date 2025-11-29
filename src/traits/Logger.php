<?php
namespace App\BibliotecaPoo\traits;

trait Logger
{
    protected function log($message)
    {
        $classe = get_class($this);
        echo "[$classe - LOG]: $message <br>";
    }
}