<?php
class produtos extends model {

	public function __construct() {
		parent::__construct();
	}

	public function listar($qt = 0) {
		$sql = "SELECT * FROM produtos ORDER BY RAND() ";
		if($qt > 0) {
			$sql .= "LIMIT ".$qt;
		}

		$sql = $this->db->query($sql);
		$produtos = array();

		if($sql->rowCount() > 0) {
			$produtos = $sql->fetchAll();
		}

		return $produtos;
	}

	public function listar_categoria($cat) {
		$sql = "SELECT * FROM produtos WHERE id_categoria = '$cat'";
		$sql = $this->db->query($sql);
		$produtos = array();
		if($sql->rowCount() > 0) {
			$produtos = $sql->fetchAll();
		}

		return $produtos;
	}

	public function get_produtos_by_id($prods = array()) {
		$array = array();

		if(is_array($prods) && count($prods) > 0) {
			$sql = "SELECT * FROM produtos WHERE id IN (".implode(',', $prods).")";
			$sql = $this->db->query($sql);
			if($sql->rowCount() > 0) {
				$array = $sql->fetchAll();
			}
		}

		return $array;
	}

	public function get_produto($id) {
		$array = array();

		$sql = "SELECT * FROM produtos WHERE id = '$id'";
		$sql = $this->db->query($sql);
		if($sql->rowCount() > 0) {
			$array = $sql->fetch();
		}

		return $array;
	}

}
?>