<?php foreach($produtos as $produto): ?>
<a href="/produto/ver/<?php echo $produto['id']; ?>">
	<div class="produto">
		<img src="/assets/images/prods/<?php echo $produto['imagem']; ?>" width="176" height="176" border="0" />
		<strong><?php echo $produto['nome']; ?></strong><br/>
		<?php echo 'R$ '.$produto['preco']; ?>
	</div>
</a>
<?php endforeach; ?>
<div style="clear:both"></div>