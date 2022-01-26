<?php
class Core
{

	public static function insert($indices = NULL, $dados = NULL, $tabela = NULL){
		$sql = MySql::conectar()->prepare("INSERT INTO $tabela ($indices) VALUES ($dados)");
		$sql->execute();

	}

	public static function select($dados = NULL,$tabela = NULL,$condicao = NULL){

		$sql = MySql::conectar()->prepare("SELECT $dados FROM $tabela WHERE $condicao");
		$sql->execute();
		$resposta = $sql->fetchAll();
		return $resposta;

	}
	public static function selectDesc($dados = NULL,$tabela = NULL,$condicao = NULL, $inicio = null,$fim = null){
		$resposta = null;
		if($inicio == null && $fim == null){
			$sql = MySql::conectar()->prepare("SELECT $dados FROM $tabela WHERE $condicao ORDER BY id DESC");
			$sql->execute();
			$resposta = $sql->fetchAll();
		}else{
			$sql = MySql::conectar()->prepare("SELECT $dados FROM $tabela WHERE $condicao ORDER BY id DESC LIMIT $inicio,$fim");
			$sql->execute();
			$resposta = $sql->fetchAll();
		}
		return $resposta;

	}

	public static function selectSingle($dados = NULL,$tabela = NULL,$condicao = NULL){

		$sql = MySql::conectar()->prepare("SELECT $dados FROM $tabela WHERE $condicao");
		$sql->execute();
		$resposta = $sql->fetch();
		return $resposta;

	}

	public static function update($dados = NULL, $tabela = NULL,$condicao = NULL){
		$sql = MySql::conectar()->prepare("UPDATE $tabela SET $dados WHERE $condicao");
		$sql->execute();
	}
	public static function remove($tabela = NULL, $condicao = NULL){
		$sql = MySql::conectar()->prepare("DELETE FROM $tabela WHERE $condicao");
		$sql->execute();
	}
	public static function logout(){
		setcookie('lembrar',true,time()-10,'/');
		session_destroy();
		header('location: '.INCLUDE_PATH);
		die();
	}
}
