<?php

require __DIR__ . '/vendor/autoload.php';

use App\ProjetoBiblioteca\Controllers\ProdutoController;
use App\ProjetoBiblioteca\log\Logger as FileLoger;
use App\ProjetoBiblioteca\db\Logger as DbLogger;

$controller = new ProdutoController();
$controller->mostrarProduto();

$filelog = new FileLoger();
$dblog = new DbLogger();