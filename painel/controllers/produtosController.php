<?php
class produtosController extends controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
    	$dados = array();
        $offset = 0;
        $limit = 10;

        if(isset($_GET['p']) && !empty($_GET['p'])) {
            $p = addslashes($_GET['p']);
            $offset = ($limit * $p) - $limit;
        }

    	$cat = new Produtos();
        $dados['limit_produtos'] = $limit;
        $dados['total_produtos'] = $cat->getTotalProdutos();
    	$dados['produtos'] = $cat->getProdutos($offset, $limit);

    	$this->loadTemplate('produtos', $dados);
    }

    public function add() {
        $dados = array(
            'categorias' => array()
        );

        $cat = new Categorias();
        $dados['categorias'] = $cat->getCategorias();

        if(isset($_POST['nome']) && !empty($_POST['nome']) && isset($_FILES['imagem']) && !empty($_FILES['imagem']['tmp_name'])) {
            $nome = addslashes($_POST['nome']);
            $descricao = addslashes($_POST['descricao']);
            $categoria = addslashes($_POST['categoria']);
            $preco = addslashes($_POST['preco']);
            $quantidade = addslashes($_POST['quantidade']);
            $imagem = $_FILES['imagem'];

            if(in_array($imagem['type'], array('image/jpeg', 'image/jpg', 'image/png'))) {
                $ext = 'jpg';
                if($imagem['type'] == 'image/png') {
                    $ext = 'png';
                }
                $md5imagem = md5(time().rand(0,9999)).'.'.$ext;
                move_uploaded_file($imagem['tmp_name'], '../assets/images/prods/'.$md5imagem);

                $prod = new Produtos();
                $prod->inserir($nome, $descricao, $categoria, $preco, $quantidade, $md5imagem);

                header("Location: /painel/produtos");
            }
        }

        $this->loadTemplate('produtos_add', $dados);
    }

    public function edit($id) {
        $dados = array(
            'categorias' => array(),
            'produto' => array()
        );

        $cat = new Categorias();
        $dados['categorias'] = $cat->getCategorias();

        $prod = new Produtos();
        $dados['produto'] = $prod->getProduto($id);

        if(isset($_POST['nome']) && !empty($_POST['nome'])) {
            $nome = addslashes($_POST['nome']);
            $descricao = addslashes($_POST['descricao']);
            $categoria = addslashes($_POST['categoria']);
            $preco = addslashes($_POST['preco']);
            $quantidade = addslashes($_POST['quantidade']);

            $prod->updateProduto($id, $nome, $descricao, $categoria, $preco, $quantidade);

            if(isset($_FILES['imagem']) && !empty($_FILES['imagem']['tmp_name'])) {
                $imagem = $_FILES['imagem'];

                if(in_array($imagem['type'], array('image/jpeg', 'image/jpg', 'image/png'))) {
                    $ext = 'jpg';
                    if($imagem['type'] == 'image/png') {
                        $ext = 'png';
                    }
                    $md5imagem = md5(time().rand(0,9999)).'.'.$ext;
                    move_uploaded_file($imagem['tmp_name'], '../assets/images/prods/'.$md5imagem);
                    
                    $prod->updateImagem($id, $md5imagem);
                }
            }


            header("Location: /painel/produtos");
            
        }

        $this->loadTemplate('produtos_edit', $dados);
    }

    public function remove($id) {

        if(!empty($id)) {

            $prod = new Produtos();
            $prod->removerProduto($id);

            header("Location: /painel/produtos");

        }

    }

    /*
    public function add() {
    	$dados = array();

    	if(isset($_POST['titulo']) && !empty($_POST['titulo'])) {

    		$cat = new Categorias();
    		$cat->addCategoria($_POST['titulo']);

    		header("Location: /painel/categorias");
    	}

    	$this->loadTemplate('categorias_add', $dados);
    }

    public function edit($id) {
    	$dados = array();

    	$cat = new Categorias();

    	if(isset($_POST['titulo']) && !empty($_POST['titulo'])){    		
    		$cat->editCategoria($_POST['titulo'], $id);

    		header("Location: /painel/categorias");
    	}

    	$dados['categoria'] = $cat->getCategoria($id);

    	$this->loadTemplate('categorias_edit', $dados);
    }

    public function remove($id) {

    	if(!empty($id)) {

    		$cat = new Categorias();
    		$cat->removeCategoria($id);

    		header("Location: /painel/categorias");

    	}

    }
    */
}
?>