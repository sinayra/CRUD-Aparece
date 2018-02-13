<?php


	class Endereco{
		private $PDO;

		private $cep, $logradouro, $bairro, $cidade, $estado;
		
		function __construct($conexao){
			$this->PDO = $conexao;
		}

		public function __set($name, $value){
	        $this->$name = $value;
	    }

	    public function __get($name){
	        $this->$name ;
	    }

		public function lista(){
			$stmt = $this->PDO->prepare("SELECT * FROM endereco");

			$stmt->execute();
			$result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
			
			return $result;
		}

		public function insert(){

			$sql = "INSERT INTO endereco (cep, logradouro, bairro, cidade, estado) " . 
					"VALUES(:cep, :logradouro, :bairro, :cidade, :estado) " . 
					"ON DUPLICATE KEY UPDATE logradouro=:logradouro, bairro=:bairro, cidade=:cidade, estado=:estado";

			
			try {
				$stmt = $this->PDO->prepare($sql);
				$stmt->execute(array(
					':cep' => $this->cep,
					':logradouro' => $this->logradouro,
					':bairro' => $this->bairro,
					':cidade' => $this->cidade,
					':estado' => $this->estado
				));

				return "ok";
			}
			catch(PDOException $e) {
  				return "Error: " . $e->getMessage();
  			}
		}

		public function selectSingle($id){
			$sql = "SELECT * FROM endereco WHERE id=:id ";

			try {
				$stmt = $this->PDO->prepare($sql);
				$stmt->execute(array(
					':id' => $id
				));

			
				$result = $stmt->fetch();
				return $result;
			}
			catch(PDOException $e) {
  				return "Error: " . $e->getMessage();
  			}
		}

		public function getID($cep){
			$sql = "SELECT id FROM endereco WHERE cep=:cep";

			try {
				$stmt = $this->PDO->prepare($sql);
				$stmt->execute(array(
					':cep' => $cep
				));

			
				$result = $stmt->fetchColumn();
				return $result;
			}
			catch(PDOException $e) {
  				return "Error: " . $e->getMessage();
  			}
			
		}
		
	}
?>