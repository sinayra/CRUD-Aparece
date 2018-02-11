<?php


	/*
	Classe pessoa
	*/
	class Sexo{
		//Atributo para banco de dados
		private $PDO;
		
		function __construct($conexao){
			$this->PDO = $conexao;
		}

		public function teste(){
			return "teste";
		}

		public function lista(){
			$sth = $this->PDO->prepare("SELECT * FROM sexo");

			$sth->execute();
			$result = $sth->fetchAll(\PDO::FETCH_ASSOC);
			
			return $result;
		}
		
	}
?>