<?php


	class Relatorio{
		private $PDO;
		
		function __construct($conexao){
			$this->PDO = $conexao;
		}


		public function lista(){
			$sql = "SELECT 	" . 
					"	p.nome AS 'nome', " .
					"	YEAR(CURRENT_TIMESTAMP) - YEAR(p.nascimento) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(p.nascimento, 5)) AS 'idade', " .
        			"	p.cpf AS 'cpf', " .
        			"	p.email AS 'email', " .
        			"	s.tipo AS 'sexo', " .
        			"	CONCAT(e.logradouro, ' ', p.end_numero) AS 'endereco', " .
        			"	e.cidade AS 'cidade', " .
        			"	e.estado AS 'estado', " .
        			"	p.ativo " .
					"FROM 		pessoa AS p " .
					"LEFT JOIN 	sexo AS s " .
					"ON			p.id_sexo = s.id " .
					"LEFT JOIN 	endereco AS e " .
					"ON 		p.id_endereco = e.id";

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

		public function countSexo($cidade = null){
			$where = "";
			if($cidade && !empty($cidade)){
				$where = "LEFT JOIN endereco AS e " .
                	"ON p.id_endereco = e.id " .
                	"WHERE e.cidade = '" . $cidade . "'";
			}

			$sql = "SELECT " . 
				"	COUNT(p.id_sexo) AS 'qtd', " . 
				"	s.tipo AS 'tipo' " . 
				"FROM pessoa AS p " . 
				"LEFT JOIN sexo AS s " . 
				"ON p.id_sexo = s.id " .
				$where .
				"GROUP BY s.id ";

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

		public function countInativo($cidade = null){
			$where = "";

			if($cidade && !empty($cidade)){
				$where = "LEFT JOIN endereco AS e " .
                	"ON p.id_endereco = e.id " .
                	"WHERE e.cidade = '" . $cidade . "'";

			}
			$sql = "SELECT " .
				"SUM(CASE WHEN p.ativo = 1 THEN 1 ELSE 0 END) AS 'qtd_ativos', " .
				"SUM(CASE WHEN p.ativo <> 1 THEN 1 ELSE 0 END) AS 'qtd_inativos' " .
				"FROM pessoa AS p " . $where;

			try {
				$stmt = $this->PDO->prepare($sql);
				$stmt->execute();

			
				$result = $stmt->fetch();
				return $result;
			}
			catch(PDOException $e) {
  				return "Error: " . $e->getMessage();
  			}
		}
		
	}
?>