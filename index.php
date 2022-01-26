<?php include "config.php"; ?>
<?php
if(isset($_GET['sair'])){
	Core::logout();
}
if(!isset($_SESSION['login'])){
	header('Location: login.php');
	die();
}

$paginaAtual = isset($_GET['pagina'])? (int)$_GET['pagina'] : 1;
$porPagina = 3;

	if(isset($_POST['acao'])){
		try{
			$tarefa = $_POST['tarefa'];
			$autor = $_POST['autor'];
			$status = $_POST['status'];

			$sql = MySql::conectar()->prepare("INSERT INTO tb_tarefas VALUES (NULL,?,?,?,0)");
			$sql->execute(array($tarefa,$autor,$status));

			echo "<script>alert('Tarefa cadastrada com sucesso!')</script>";
			header("Location: index.php?pagina=1");

		}catch(Exception $e){
			echo "<script>alert('algo deu errado!')</script>";
			header("Location: index.php?pagina=1");

		}

	}

	if(isset($_GET['excluir'])){
		try{
			$tarefaID = $_GET['excluir'];
			$sql = MySql::conectar()->prepare("DELETE FROM tb_tarefas WHERE id=?");
			$sql->execute(array($tarefaID));

			echo "<script>alert('Tarefa exluida com sucesso!')</script>";
			header("Location: index.php");

		}catch(Exception $e){
			echo "<script>alert('algo deu errado!')</script>";
			header("Location: index.php");

		}
	}

 ?>
 <?php $nome = $_SESSION['nome'];  ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Lista de tarefas do Ton</title>
	<link rel="apple-touch-icon" sizes="180x180" href="assets/favicon_app.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon_app.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon_app.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="assets/favicon_app.png" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#668">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
</head>
<body class="noturno-">
	<header id="header">
		<h2>App Lista de Tarefas</h2>
	</header>
	<div class="main-wraper">


	<div class="container top-4 card-blue-">
		<span class="right "><a class="blue-text btn-sair" href="index.php?sair=1">Sair</a></span>
		<h2 style="text-transform: uppercase;">Lista de tarefas de <?php echo $nome;?></h2>
		<br>
		<form method="post">
			<span>Tarefa</span>
			<input required="" type="text" name="tarefa" placeholder="texto descritivo">
			<span>Autor</span>
			<input required="" type="text" name="autor" value="<?php echo $nome?>" placeholder="nome do autor">
			<span>Status</span>
			<select name="status">
				<option>aberta</option>
				<option>em pausa</option>
				<option>aguardando...</option>
				<option>finalizada</option>
			</select>
			<button type="submit" name="acao">Salvar</button>
		</form>
	</div>
		<div class="container top-4 card-blue-">
		<div class="lista-tarefas">
			<table>
				<tr class="cabecalho">
					<th>ID</th>
					<th width="40%">Tarefa</th>
					<th>Autor</th>
					<th>Status</th>
					<th>Editar</th>
					<th>Excluir</th>
				</tr>
				<?php
					$tarefas = Core::selectDesc('*','tb_tarefas','true',($paginaAtual-1)*$porPagina,$porPagina);

					foreach ($tarefas as $key => $value) {//inicio?>
				<tr>
					<td>#<?php echo $value['id']; ?></td>
					<td><?php echo $value['tarefa']; ?></td>
					<td><?php echo $value['autor']; ?></td>
					<td <?php echo 'class='.$value['status']; ?>><?php echo $value['status']; ?></td>
					<td><a class="editar" href="editar-tarefa.php?id=<?php echo $value['id']; ?>&status=<?php echo $value['status']; ?>">Editar</a></td>
					<td><a class="remove" href="index.php?excluir=<?php echo $value['id']; ?>">Excluir</a></td>
				</tr>
				<?php }//fim do foreach ?>
			</table>
		</div><!--lista-tarefas-->
		<div class="btns-page-box">
		<?php

		//PAGINAÇÃO AQUI:
		if(!isset($_GET['pagina'])){
			header('location:'.INCLUDE_PATH.'?pagina=1');
		}
		$totalPaginas = ceil(count(Core::select("*","tb_tarefas",true))/$porPagina);
		for ($i=0; $i < $totalPaginas; $i++) {
			$numero = $i+1;
			if(isset($_GET['pagina'])&&$_GET['pagina'] == $numero){
				echo '<a class=btn style="background-color:#4444bb;" href='.INCLUDE_PATH.'?pagina='.$numero.'>'.$numero.'</a>';
			}else{
				echo '<a class=btn href='.INCLUDE_PATH.'?pagina='.$numero.'>'.$numero.'</a>';
			}
		}
		//FIM DA LÓGICA DE PAGINAÇÃO

		 ?>
	</div>
	</div><!--container-->

	</div><!--main-wraper-->
	<footer>by Ejiraia (Eliton Aranda) <i class="far fa-laugh-wink"></i></footer>

	<script type="text/javascript">
		var remover = document.querySelectorAll('.remove')
		var editar = document.querySelectorAll('.editar')

		for(i= 0; i < editar.length; i++){
			editar[i].style.color = "#349"
		}
		//console.log(remover.length)
		for(i=0; i< remover.length;i++){
				remover[i].style.color = "#934"

			remover[i].onclick = function(){
					confirme = confirm("Realmente deseja excluir a tarefa?")
					if(confirme){
					}else{
						return false
					}
			}
		}


	</script>

</body>
</html>
