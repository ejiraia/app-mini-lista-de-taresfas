<?php include "config.php"; ?>
<?php
	if(isset($_GET['id'])){
		$tarefaID = $_GET['id'];
		$sql = MySql::conectar()->prepare("SELECT * FROM tb_tarefas WHERE id = ?");
		$sql->execute(array($tarefaID));
		$tarefa = $sql->fetch();
	}
	if(isset($_POST['acao'])){
		$autor = $_POST['autor'];
		$tarefa = $_POST['tarefa'];
		$status = $_POST['status'];
		$sql = MySql::conectar()->prepare("UPDATE tb_tarefas SET tarefa = ?, autor = ?, status = ? WHERE id = ?");
		$sql->execute(array($tarefa,$autor,$status,$tarefaID));
		header("Location: index.php");
	}
	function selecionado($status){
		if(isset($_GET['status'])){
			$statusAtual = $_GET['status'];
			if($status == $statusAtual){
				echo "selected=''";
			}
		}
	}

 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Lista de tarefas</title>
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
</head>
<body>
	<header id="header">
		<h2>App Lista de Tarefas</h2>
	</header>
	<div class="main-wraper">

	<div class="container top-6
	">
		<h2>Editar Tarefa: #<?php echo $tarefaID ?></h2>
		<br>
		<form method="post">
			<span>Tarefa</span>
			<input type="text" name="tarefa" placeholder="texto descritivo" value="<?php echo $tarefa['tarefa'] ?>">
			<span>Autor</span>
			<input type="text" name="autor" placeholder="nome do autor" value="<?php echo $tarefa['autor'] ?>">
			<span>Status</span>
			<select name="status">
				<option <?php selecionado('aberta')?> >aberta</option>
				<option <?php selecionado('em pausa')?>>em pausa</option>
				<option <?php selecionado('processando')?>>processando</option>
				<option <?php selecionado('finalizada')?>>finalizada</option>
			</select>
			<button type="submit" name="acao">Salvar</button>
			<a class="btn" style="color: white;background: #a33b;" href="index.php?pagina=1">Cancela</a>
		</form>
		<div class="lista-tarefas">

		</div><!--lista-tarefas-->
	</div>
</div>
<footer style="position:fixed;bottom:0;">by Ejiraia (Eliton Aranda) <i class="far fa-laugh-wink"></i></footer>

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
