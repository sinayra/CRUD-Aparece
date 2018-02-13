<?php


	class Pessoa{
		private $PDO;

		private $nome, $nascimento, $cpf, $email, $id_endereco, $end_numero, $id_sexo, $ativo;
		
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
			$stmt = $this->PDO->prepare("SELECT * FROM pessoa");

			$stmt->execute();
			$result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
			
			return $result;
		}

		public function listaNomeCPFPor($order){
			$sql = "SELECT 	" . 
					"	p.id AS 'id', " .
					"	p.nome AS 'nome', " .
        			"	p.cpf AS 'cpf', " .
        			"	p.ativo AS 'ativo' " .
					"FROM 		pessoa AS p " .
					"ORDER BY 	" . $order;

			try {
				$stmt = $this->PDO->prepare($sql);
				$stmt->execute();

			
				$result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
				return $result;
			}
			catch(PDOException $e) {
  				return "Error: " . $e->getMessage();
  			}

		}
	

		public function insert(){

			$sql = 'INSERT INTO pessoa (nome, nascimento, cpf, email, id_endereco, end_numero, id_sexo) ' . 
					'VALUES(:nome, :nascimento, :cpf, :email, :id_endereco, :end_numero, :id_sexo) ';

			try {

				$stmt = $this->PDO->prepare($sql);
				$stmt->execute(array(
					':nome' => $this->nome,
					':nascimento' => $this->nascimento,
					':cpf' => $this->cpf,
					':email' => $this->email,
					':id_endereco' => $this->id_endereco,
					':end_numero' => $this->end_numero,
					':id_sexo' => $this->id_sexo
				));

				return "ok";
			}
			catch(PDOException $e) {
  				return "Error: " . $e->getMessage();
  			}
		}

		public function delete($id){

			$sql = 'DELETE FROM pessoa WHERE id=:id';

			try {

				$stmt = $this->PDO->prepare($sql);
				$stmt->execute(array(
					':id' => $id
				));

				return "ok";
			}
			catch(PDOException $e) {
  				return "Error: " . $e->getMessage();
  			}
		}

		public function selectSingle($id){
			$sql = "SELECT * FROM pessoa WHERE id=:id ";

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

		public function update($id){

			$sql = 'UPDATE pessoa SET nome=:nome, nascimento=:nascimento, cpf=:cpf, email=:email, id_endereco=:id_endereco, end_numero=:end_numero, id_sexo=:id_sexo, ativo=:ativo WHERE id = :id';

			try {

				$stmt = $this->PDO->prepare($sql);
				$stmt->execute(array(
					':nome' => $this->nome,
					':nascimento' => $this->nascimento,
					':cpf' => $this->cpf,
					':email' => $this->email,
					':id_endereco' => $this->id_endereco,
					':end_numero' => $this->end_numero,
					':id_sexo' => $this->id_sexo,
					':ativo' => $this->ativo,
					':id' => $id
				));

				return "ok";
			}
			catch(PDOException $e) {
  				return "Error: " . $e->getMessage();
  			}
		}
		
	}
?>