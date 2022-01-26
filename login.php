<?php

include "config.php";

/*$usuarioDB = Core::select("*","usuarios","usuario = 'Eliton'");

echo "<pre>";
print_r($usuarioDB);
echo "</pre>";
*/

if(isset($_POST['acao'])){

	$login = $_POST['login'];
	$senha = $_POST['senha'];

	$sql = MySql::conectar()->prepare('SELECT * FROM usuarios WHERE login = ? AND senha =?');
	$sql->execute(array($login,$senha));

	if($sql->rowCount() == 1){
		$infoUser = $sql->fetch();

		$_SESSION['login'] = true;
		$_SESSION['nome'] = $infoUser['usuario'];

		header('Location: index.php');
	}else{
		//falha ao logar
		echo "<span class=erro-login>Usuario ou senha incorretos!</span>";
	}
}

?>

<link rel="apple-touch-icon" sizes="180x180" href="assets/favicon_app.png">
<link rel="icon" type="image/png" sizes="32x32" href="assets/favicon_app.png">
<link rel="icon" type="image/png" sizes="16x16" href="assets/favicon_app.png">
<link rel="manifest" href="/site.webmanifest">
<link rel="mask-icon" href="assets/favicon_app.png" color="#5bbad5">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#448">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0">

<link rel="stylesheet" type="text/css" href="css/estilos.css">
<style type="text/css">

	.box-login{
		width: 100vh;
		max-width: 430px;
		margin: 20px auto;
		margin-top: 80px;
		border-top: 4px solid #33e;
	}
	.erro-login{
		width: auto;
		max-width: 430px;
		background: #88fe;
		padding: 10px;
		display: block;
		margin: 0 auto;
		position: relative;
		top: 60px;
		text-align: center;
		border-left: 3px solid #66f;
		color: #fff;
	}
</style>
<div class="box-login container">
<form method="post">
	<h2 style="text-transform:;">Bem vindo(a) ao Gerenciador de tarefas
	</h2>
	<br>
	<p>*Faça login para prosseguir...</p>
	<input type="text" name="login" placeholder="login">
	<input type="password" name="senha" placeholder="senha">
	<input class="btn blue" type="submit" name="acao" value="Entrar">
</form>
</div>
