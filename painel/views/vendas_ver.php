<?php global $config; ?>
<h1>Venda </h1>

<fieldset>
	<legend>Informações da venda</legend>
	<table border="0" width="100%">
		<tr>
			<td valign="top" width="50%">
				<strong>ID da venda:</strong> <?php echo $venda['id']; ?><br/>
				<strong>Nome do cliente:</strong> <?php echo $venda['nome_usuario']; ?><br/>
				<strong>Valor da venda:</strong> R$ <?php echo $venda['valor']; ?><br/>
				<strong>Tipo de pagamento:</strong> <?php echo $venda['pg_nome']; ?><br/>
				<strong>Status de pagamento:</strong> <?php echo $config['status_pgto'][$venda['status_pg']]; ?><br/><br/>

				<form method="POST">
					<select name="status">
						<option></option>
						<?php foreach($config['status_pgto'] as $stid => $st): ?>
						<option value="<?php echo $stid; ?>"><?php echo $st; ?></option>
						<?php endforeach; ?>
					</select>
					<input type="submit" value="Alterar Status" />
				</form> 
			</td>
			<td valign="top">
				<strong>Endereço para entrega:</strong><br/>
				<?php echo utf8_encode($venda['endereco']); ?>
			</td>
		</tr>
	</table>
</fieldset>

<h3>Produtos da venda</h3>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Imagem</th>
			<th>Nome</th>
			<th>Qtd.</th>
			<th>Preço</th>
		</tr>
	</thead>
	<?php foreach($produtos as $prod): ?>
	<tr>
		<td width="100"><img src="/assets/images/prods/<?php echo $prod['imagem']; ?>" border="0" width="100" /></td>
		<td><?php echo $prod['nome']; ?></td>
		<td><?php echo $prod['quantidade']; ?></td>
		<td>R$ <?php echo $prod['preco']; ?></td>
	</tr>
	<?php endforeach; ?>
</table>