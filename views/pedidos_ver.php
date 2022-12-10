<?php global $config; ?>

<h1>Seu Pedido</h1>
<table border="0" width="100%">
	<tr>
		<th>Nº do pedido</th>
		<th>Valor Pago</th>
		<th>Forma de Pgto</th>
		<th>Status do Pgto.</th>
	</tr>
	<tr>
		<td><?php echo $pedido['id']; ?></td>
		<td>R$ <?php echo $pedido['valor']; ?></td>
		<td><?php echo $pedido['tipopgto']; ?></td>
		<td><?php echo $config['status_pgto'][$pedido['status_pg']]; ?></td>
	</tr>
</table>

<hr/>

<?php foreach($pedido['produtos'] as $produto): ?>
<div class="pedido_produto">
	<img src="/assets/images/prods/<?php echo $produto['imagem']; ?>" border="0" width="100" /><br/>
	<?php echo $produto['nome']; ?><br/>
	R$ <?php echo $produto['preco']; ?><br/>
	Quantidade: <?php echo $produto['quantidade']; ?>
</div>
<?php endforeach; ?>

<div style="clear:both"></div>