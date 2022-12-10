<h1>Página de LOGIN</h1>

<?php if(!empty($aviso)): ?>
<div style="background-color:red;color:#FFF;padding:15px"><?php echo $aviso; ?></div>
<?php endif; ?>

<form method="POST">
	E-mail:<br/>
	<input type="email" name="email" /><br/><br/>

	Senha:<br/>
	<input type="password" name="senha" /><br/><br/>

	<input type="submit" value="Logar" />
</form>