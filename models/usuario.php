<?php
class usuario extends model {

	public function __construct() {
		parent::__construct();
	}
	
	public function isExiste($email, $senha = '') {
		if(!empty($senha)) {
			$sql = "SELECT * FROM usuarios WHERE email = '$email' AND senha = MD5('$senha')";
		} else {
			$sql = "SELECT * FROM usuarios WHERE email = '$email'";
		}
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function criar($nome, $email, $senha) {
		$sql = "INSERT INTO usuarios SET nome = '$nome', email = '$email', senha = MD5('$senha')";
		$this->db->query($sql);

		return $this->db->lastInsertId();
	}

	public function getId($email) {
		$id = 0;

		$sql = "SELECT id FROM usuarios WHERE email = '$email'";
		$sql = $this->db->query($sql);
		if($sql->rowCount() > 0) {
			$sql = $sql->fetch();
			$id = $sql['id'];
		}

		return $id;
	}

}