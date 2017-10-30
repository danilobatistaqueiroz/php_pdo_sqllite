<?php namespace CDC\Persistencia;

$lite = new SqlLiteConn();
$lite->execute();

class SqlLiteConn {

    private $conexao;

    public function execute() {
        $this->conexao = new \PDO("sqlite:test.db");
        $this->conexao->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->criaTabela();
		$this->adiciona("intel",15000,1);
		$produtosAtivos = $this->ativos();
		echo $produtosAtivos[0]["valor_unitario"] . "<BR/>\r\n";
		echo count($produtosAtivos);
		//echo $produtosAtivos[1]["valor_unitario"];
		$this->conexao = null;
        //unlink("test.db");
    }

    protected function criaTabela() {
        $sqlString = "CREATE TABLE IF NOT EXISTS produto (id INTEGER PRIMARY KEY, descricao TEXT, valor_unitario TEXT, status TINYINT(1) );";
        $this->conexao->query($sqlString);
    }
	
    public function ativos() {
        $sqlString = "SELECT * FROM produto WHERE status=1";
        $consulta = $this->conexao->query($sqlString);
        return $consulta->fetchAll(\PDO::FETCH_ASSOC);
    }
	
    public function adiciona($nome, $valorUnitario, $status) {
        $sqlString = "INSERT INTO `produto` (descricao,valor_unitario,status) VALUES (?, ?, ?)";
        $stmt = $this->conexao->prepare($sqlString);
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $valorUnitario);
        $stmt->bindParam(3, $status);
        $stmt->execute();
        return $this->conexao;
    }
}