<?php
class Categorias extends model {

	public function getCategorias() {
		$array = array();

		$sql = "SELECT * FROM categorias";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}

		return $array;
	}

	public function getCategoria($id) {
		$array = array();
		$id = addslashes($id);

		$sql = "SELECT * FROM categorias WHERE id = '$id'";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetch();
		}

		return $array;
	}

	public function addCategoria($titulo) {
		if(!empty($titulo)) {
			$titulo = addslashes($titulo);
			$sql = "INSERT INTO categorias SET titulo = '$titulo'";
			$this->db->query($sql);
		}
	}

	public function editCategoria($titulo, $id) {
		if(!empty($titulo) && !empty($id)) {
			$titulo = addslashes($titulo);
			$id = addslashes($id);

			$sql = "UPDATE categorias SET titulo = '$titulo' WHERE id = '$id'";
			$this->db->query($sql);			
		}
	}

	public function removeCategoria($id) {
		$id = addslashes($id);
		$sql = "DELETE FROM categorias WHERE id = '$id'";
		$this->db->query($sql);

		$sql = "DELETE FROM produtos WHERE id_categoria = '$id'";
		$this->db->query($sql);
	}

}