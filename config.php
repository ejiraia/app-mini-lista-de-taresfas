<?php 

session_start();

//AUTOLOAD
function autoload ($class){

	include 'classes/'.$class.'.php';
}
spl_autoload_register('autoload');
//------------------------------------------//

//CONSTANTES DE CONEXÃO COM O BANCO DE DADOS:
define('HOST', 'localhost');
define('USER', 'root');
define('PASSWORD', '');
define('DATABASE', 'lista_tarefas');

//CAMINHOS DA RAIZ DO SITE:
define("INCLUDE_PATH", 'http://localhost/AppListaDeTarefas/index.php');
 ?>