<h1>Produtos - Editar</h1>
<form method="POST" enctype="multipart/form-data">

	<input type="text" name="nome" value="<?php echo utf8_encode($produto['nome']); ?>" placeholder="Nome do produto" class="form-control" /><br/>

	<textarea name="descricao" placeholder="Descrição do produto" class="form-control"><?php echo utf8_encode($produto['descricao']); ?></textarea><br/>

	<select name="categoria" class="form-control">
		<?php foreach($categorias as $categoria): ?>
		<option <?php echo ($categoria['id']==$produto['id_categoria'])?'selected="selected"':''; ?> value="<?php echo $categoria['id']; ?>"><?php echo utf8_encode($categoria['titulo']); ?></option>
		<?php endforeach; ?>
	</select><br/>

	<input type="text" name="preco" value="<?php echo $produto['preco']; ?>" placeholder="Preço do produto" class="form-control" /><br/>

	<input type="text" name="quantidade" value="<?php echo $produto['quantidade']; ?>" placeholder="Quantidade em estoque" class="form-control" /><br/>

	<input type="file" name="imagem" />
	<img src="/assets/images/prods/<?php echo $produto['imagem']; ?>" border="0" height="100" />
	<br/><br/>

	<input type="submit" value="Salvar" class="btn btn-default" />

</form>