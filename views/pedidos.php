<?php
global $config;
?>
<h1>Seus Pedidos</h1>

<a href="/login/logout">Sair</a>

<table border="0" width="100%">
	<tr>
		<th>Nº do pedido</th>
		<th>Valor Pago</th>
		<th>Forma de Pgto</th>
		<th>Status do Pgto.</th>
		<th>Ações</th>
	</tr>
	<?php foreach($pedidos as $pedido): ?>
	<tr>
		<td><?php echo $pedido['id']; ?></td>
		<td>R$ <?php echo $pedido['valor']; ?></td>
		<td><?php echo $pedido['tipopgto']; ?></td>
		<td><?php echo $config['status_pgto'][$pedido['status_pg']]; ?></td>
		<td><a href="/pedidos/ver/<?php echo $pedido['id']; ?>">Detalhes</a></td>
	</tr>
	<?php endforeach; ?>
</table>