<?php
class Produtos extends model {

	public function getProduto($id) {
		$array = array();

		$sql = "SELECT * FROM produtos WHERE id = '$id'";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetch();
		}

		return $array;
	}

	public function getProdutos($offset, $limit) {
		$array = array();

		$sql = "SELECT *, (select categorias.titulo from categorias where categorias.id = produtos.id_categoria) as categoria FROM produtos LIMIT $offset, $limit";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}

		return $array;
	}

	public function getTotalProdutos() {
		$q = 0;

		$sql = "SELECT COUNT(*) as c FROM produtos";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$q = $sql->fetch();
			$q = $q['c'];
		}

		return $q;
	}

	public function inserir($nome, $descricao, $categoria, $preco, $quantidade, $md5imagem) {

		$sql = "INSERT INTO produtos SET nome = '$nome', descricao = '$descricao', id_categoria = '$categoria', preco = '$preco', quantidade = '$quantidade', imagem = '$md5imagem'";
		$this->db->query($sql);		

	}

	public function updateProduto($id, $nome, $descricao, $categoria, $preco, $quantidade) {

		$sql = "UPDATE produtos SET nome = '$nome', descricao = '$descricao', id_categoria = '$categoria', preco = '$preco', quantidade = '$quantidade' WHERE id = '$id'";
		$this->db->query($sql);		

	}

	public function updateImagem($id, $imagem) {

		$sql = "UPDATE produtos SET imagem = '$imagem' WHERE id = '$id'";
		$this->db->query($sql);

	}

	public function removerProduto($id) {

		$sql = "SELECT imagem FROM produtos WHERE id = '$id'";
		$sql = $this->db->query($sql);
		if($sql->rowCount() > 0) {
			$img = $sql->fetch();
			$img = $img['imagem'];

			unlink('../assets/images/prods/'.$img);

			$this->db->query("DELETE FROM produtos WHERE id = '$id'");
		}

	}


}
?>