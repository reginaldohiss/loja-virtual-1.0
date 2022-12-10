<?php
class carrinhoController extends controller {
	
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$dados = array();
		$prods = array();
		if(isset($_SESSION['carrinho'])) {
			$prods = $_SESSION['carrinho'];
		}

		if(count($prods)) {
			$produtos = new produtos();
			$dados['produtos'] = $produtos->get_produtos_by_id($prods);

			$this->loadTemplate("carrinho", $dados);
		} else {
			header("Location: /");
		}
	}

	public function add($id='') {
		if(!empty($id)) {
			if(!isset($_SESSION['carrinho'])) {
				$_SESSION['carrinho'] = array();
			}

			$_SESSION['carrinho'][] = $id;

			header("Location: /carrinho");
		}
	}

	public function del($id) {
		if(!empty($id)) {

			foreach($_SESSION['carrinho'] as $cchave => $cvalor) {
				if($id == $cvalor) {
					unset($_SESSION['carrinho'][$cchave]);
				}
			}

			header("Location: /carrinho");
		}
	}

	public function finalizar() {
		$dados = array(
			'total' => 0,
			'sessionId' => '',
			'erro' => '',
			'produtos' => array()
		);

		require 'libraries/PagSeguroLibrary/PagSeguroLibrary.php';

		$prods = array();
		if(isset($_SESSION['carrinho'])) {
			$prods = $_SESSION['carrinho'];
		}

		if(count($prods) > 0) {
			$produtos = new produtos();
			$dados['produtos'] = $produtos->get_produtos_by_id($prods);

			foreach($dados['produtos'] as $prod) {
				$dados['total'] += $prod['preco'];
			}
		}

		if(isset($_POST['pg_form']) && !empty($_POST['pg_form'])) {

			$nome = addslashes($_POST['nome']);
			$email = addslashes($_POST['email']);
			$senha = addslashes($_POST['senha']);
			$sessionId = addslashes($_POST['sessionId']);

			if(!empty($email) && !empty($senha)) {

				$uid = 0;
				$u = new usuario();
				if($u->isExiste($email)) {
					if($u->isExiste($email, $senha)) {
						$uid = $u->getId($email);
					} else {
						$dados['erro'] = "Usuário e/ou senha errados!";
					}
				} else {
					$uid = $u->criar($nome, $email, $senha);
				}

				if($uid > 0) {

					$vendas = new vendas();
					$venda = $vendas->setVendaCkTransparente($_POST, $uid, $sessionId, $dados['produtos'], $dados['total']);

					$tipo = $venda->getPaymentMethod()->getType()->getValue();

					if($tipo == '4') { // Boleto
						$link = $venda->getPaymentLink();
						$vendas->setLinkBySession($link, $sessionId);
						header("Location: ".$link);
					} else {
						header("Location: /carrinho/obrigado");
					}

				}

			} else {
				$dados['erro'] = "Preencha todos os campos";
			}

		} else {
			try {
				$credentials = PagSeguroConfig::getAccountCredentials();
				$dados['sessionId'] = PagSeguroSessionService::getSession($credentials);
			} catch(PagSeguroServiceException $e) {
				die($e->getMessage());
			}
		}
		
		$this->loadTemplate('finalizar_compra', $dados);
	}

	public function notificacao() {
		$vendas = new vendas();
		$vendas->verificarVendas();
	}

	public function obrigado() {
		$dados = array();

		$this->loadTemplate("obrigado", $dados);

	}

}
?>