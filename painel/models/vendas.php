<?php
class vendas extends model {

	public function getVendas() {
		$array = array();

		$sql = "SELECT
			vendas.id,
			usuarios.nome as nome_usuario,
			vendas.valor,
			pagamentos.nome as pg_nome,
			vendas.status_pg 
		FROM vendas
		LEFT JOIN usuarios ON usuarios.id = vendas.id_usuario
		LEFT JOIN pagamentos ON pagamentos.id = vendas.forma_pg
		";

		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}

		return $array;
	}

	public function getVenda($id) {
		$array = array();

		$sql = "SELECT
			vendas.id,
			usuarios.nome as nome_usuario,
			vendas.valor,
			pagamentos.nome as pg_nome,
			vendas.status_pg,
			vendas.endereco,
			vendas.pg_link 
		FROM vendas
		LEFT JOIN usuarios ON usuarios.id = vendas.id_usuario
		LEFT JOIN pagamentos ON pagamentos.id = vendas.forma_pg
		WHERE
			vendas.id = '$id'
		";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetch();
		}

		return $array;
	}

	public function getProdutos($id) {
		$array = array();

		$sql = "SELECT id_produto, quantidade FROM vendas_produtos WHERE id_venda = '$id'";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$prods = $sql->fetchAll();

			$p = new Produtos();
			foreach($prods as $prod) {
				$pinfo = $p->getProduto($prod['id_produto']);

				$array[] = array(
					'id' => $pinfo['id'],
					'quantidade' => $prod['quantidade'],
					'nome' => $pinfo['nome'],
					'imagem' => $pinfo['imagem'],
					'preco' => $pinfo['preco']
				);
			}
		}

		return $array;
	}

	public function updateStatus($status, $id) {
		$sql = "UPDATE vendas SET status_pg = '$status' WHERE id = '$id'";
		$this->db->query($sql);
	}

}
?>