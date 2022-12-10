<?php
global $config;
?>
<h1>Vendas</h1>

<table class="table table-striped">
	<thead>
		<tr>
			<th width="50">ID</th>
			<th>Nome do cliente</th>
			<th>Valor</th>
			<th>Forma Pgto.</th>
			<th>Status</th>
			<th width="200">Ações</th>
		</tr>
	</thead>
	<?php foreach($vendas as $venda): ?>
		<tr>
			<td><?php echo $venda['id']; ?></td>
			<td><?php echo $venda['nome_usuario']; ?></td>
			<td>R$ <?php echo $venda['valor']; ?></td>
			<td><?php echo $venda['pg_nome']; ?></td>
			<td><?php echo $config['status_pgto'][$venda['status_pg']]; ?></td>
			<td>
				<a href="/painel/vendas/ver/<?php echo $venda['id']; ?>">Visualizar</a>
			</td>
		</tr>
	<?php endforeach; ?>
</table>