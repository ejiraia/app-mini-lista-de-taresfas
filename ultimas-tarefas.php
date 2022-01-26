<?php include "config.php"; ?>
<?php 
	if(isset($_POST['acao'])){
		try{
			$tarefa = $_POST['tarefa'];
			$autor = $_POST['autor'];
			$status = $_POST['status'];

			$sql = MySql::conectar()->prepare("INSERT INTO tb_tarefas VALUES (NULL,?,?,?)");
			$sql->execute(array($tarefa,$autor,$status));

			echo "<script>alert('Tarefa cadastrada com sucesso!')</script>";
			header("Location: index.php");

		}catch(Exception $e){
			echo "<script>alert('algo deu errado!')</script>";
			header("Location: index.php");

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
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Lista de tarefas do Ton</title>
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
</head>
<body>
	
	<div class="container">
		<h2>Lista de tarefas do Ton</h2>
		<br>
		<form method="post">
			<span>Tarefa</span>
			<input required="" type="text" name="tarefa" placeholder="texto descritivo">
			<span>Autor</span>
			<input required="" type="text" name="autor" placeholder="nome do autor">
			<span>Status</span>
			<select name="status">
				<option>aberta</option>
				<option>em pausa</option>
				<option>aguardando...</option>
				<option>finalizada</option>
			</select>
			<button type="submit" name="acao">Salvar</button>
		</form>
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
					$sql = MySql::conectar()->prepare("SELECT * FROM tb_tarefas");
					$sql->execute();
					$tarefas = $sql->fetchAll();
					//print_r($tarefas);
					foreach ($tarefas as $key => $value) {//inicio?>
				<tr>
					<td>#<?php echo $value['id']; ?></td>
					<td><?php echo $value['tarefa']; ?></td>
					<td><?php echo $value['autor']; ?></td>
					<td><?php echo $value['status']; ?></td>
					<td><a class="editar" href="editar-tarefa.php?id=<?php echo $value['id']; ?>&status=<?php echo $value['status']; ?>">Editar</a></td>
					<td><a class="remove" href="index.php?excluir=<?php echo $value['id']; ?>">Excluir</a></td>
				</tr>
				<?php }//fim do foreach ?>
			</table>
		</div><!--lista-tarefas-->
	</div>
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