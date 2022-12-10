<?php
class loginController extends controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$dados = array(
			'aviso' => ''
		);

		if(isset($_POST['email']) && !empty($_POST['email'])) {

			$email = addslashes($_POST['email']);
			$senha = addslashes($_POST['senha']);

			$usuario = new usuario();
			if($usuario->isExiste($email, $senha)) {
				$_SESSION['cliente'] = $usuario->getId($email);

				header("Location: /pedidos");
			} else {
				$dados['aviso'] = "Email e/ou Senha não estão corretos!";
			}

		}

		$this->loadTemplate("login", $dados);		
	}

	public function logout() {
		unset($_SESSION['cliente']);
		header("Location: /login");
	}

}
?>