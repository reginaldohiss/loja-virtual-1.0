<h1>Contato</h1>

<form method="POST" class="contato">

	<?php if(!empty($msg)): ?>
	<div class="aviso"><?php echo $msg; ?></div>
	<?php endif; ?>

	Nome:<br/>
	<input type="text" name="nome" required /><br/><br/>

	E-mail:<br/>
	<input type="email" name="email" required /><br/><br/>

	Mensagem:<br/>
	<textarea name="mensagem"></textarea><br/><br/>

	<input type="submit" value="Enviar Mensagem" />

</form>

<div style="clear:both"></div>