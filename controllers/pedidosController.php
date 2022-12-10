<?php
class pedidosController extends controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$dados = array();

		if(isset($_SESSION['cliente']) && !empty($_SESSION['cliente'])) {

			$vendas = new vendas();
			$dados['pedidos'] = $vendas->getPedidosDoUsuario($_SESSION['cliente']);


			$this->loadTemplate("pedidos", $dados);
		} else {
			header("Location: /login");
		}
		
	}

	public function ver($id) {
		if(!empty($id)) {
			$dados = array();
			$id = addslashes($id);

			$vendas = new vendas();
			$dados['pedido'] = $vendas->getPedido($id, $_SESSION['cliente']);

			if(count($dados['pedido']) == 0) {
				header("Location: /pedidos");
			}

			$this->loadTemplate("pedidos_ver", $dados);
		} else {
			header("Location: /pedidos");
		}
	}

}
?>