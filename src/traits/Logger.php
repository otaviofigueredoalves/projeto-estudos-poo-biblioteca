<?php
namespace App\BibliotecaPoo\traits;

trait Logger
{
    protected static function log($message)
    {
        $classe = static::class;
        echo "[$classe - LOG]: $message <br>";
    }
}