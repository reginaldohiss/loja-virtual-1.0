<html>
	<head>
		<title>Nossa Loja</title>
		<link rel="stylesheet" href="/assets/css/template.css" />
	</head>
	<body>
		<div class="topo">
			<img src="/assets/images/logo.png" border="0" height="70" />
		</div>
		<div class="menu">
			<div class="menuint">
				<ul>
					<a href="/"><li>home</li></a>
					<a href="/empresa"><li>empresa</li></a>
					<?php foreach($menu as $menuitem): ?>
					<a href="/categoria/ver/<?php echo $menuitem['id']; ?>"><li><?php echo utf8_encode($menuitem['titulo']); ?></li></a>
					<?php endforeach; ?>
					<a href="/contato"><li>contato</li></a>
					<a href="/pedidos"><li>pedidos</li></a>
				</ul>
				<a href="/carrinho">
					<div class="carrinho">
						Carrinho:<br/>
						<?php echo (isset($_SESSION['carrinho']))?count($_SESSION['carrinho']):'0'; ?> itens
					</div>
				</a>
			</div>
		</div>
		<div class="container">
			<?php $this->loadViewInTemplate($viewName, $viewData); ?>
		</div>
		<div class="rodape"></div>
	</body>
</html>