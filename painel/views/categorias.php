<h1>Categorias</h1>

<a href="/painel/categorias/add" class="btn btn-default">Adicionar Categoria</a>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Titulo</th>
			<th width="200">Ações</th>
		</tr>
	</thead>
	<?php foreach($categorias as $cat): ?>
	<tr>
		<td><?php echo utf8_encode($cat['titulo']); ?></td>
		<td>
			<a href="/painel/categorias/edit/<?php echo $cat['id']; ?>" class="btn btn-default">Editar</a>
			<a href="/painel/categorias/remove/<?php echo $cat['id']; ?>" class="btn btn-default">Excluir</a>
		</td>
	</tr>
	<?php endforeach; ?>
</table>