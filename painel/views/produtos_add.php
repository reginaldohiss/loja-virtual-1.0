<h1>Produtos - Adicionar</h1>
<form method="POST" enctype="multipart/form-data">

	<input type="text" name="nome" placeholder="Nome do produto" class="form-control" /><br/>

	<textarea name="descricao" placeholder="Descrição do produto" class="form-control"></textarea><br/>

	<select name="categoria" class="form-control">
		<?php foreach($categorias as $categoria): ?>
		<option value="<?php echo $categoria['id']; ?>"><?php echo utf8_encode($categoria['titulo']); ?></option>
		<?php endforeach; ?>
	</select><br/>

	<input type="text" name="preco" placeholder="Preço do produto" class="form-control" /><br/>

	<input type="text" name="quantidade" placeholder="Quantidade em estoque" class="form-control" /><br/>

	<input type="file" name="imagem" /><br/>

	<input type="submit" value="Salvar" class="btn btn-default" />

</form>