<h2>Login</h2>

<?php foreach ($errors as $v): ?>

	<?php echo $v; ?><br />

<?php endforeach; ?>

<?php echo form::open(); ?>

<fieldset>
	<dl>
		<dt><?php echo form::label('username', 'Username:'); ?></dt>
		<dd><?php echo form::input('username'); ?></dd>
	</dl>
	<dl>
		<dt><?php echo form::label('password', 'Password:'); ?></dt>
		<dd>
			<?php echo form::password('password'); ?>
		</dd>
	</dl>
	<dl>
		<dt>&nbsp;</dt>
		<dd><?php echo form::label('remember', form::checkbox('remember').'Remember me'); ?></dd>
	</dl>
	
	<?php echo form::submit('login', 'Login'); ?>
</fieldset>
<?php echo form::close(); ?>