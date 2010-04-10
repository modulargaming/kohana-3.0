<h2><?php echo __('Login') ?></h2>

<?php echo Message::display(); ?>

<?php echo form::open(); ?>
<fieldset>
	<dl>
		<dt><?php echo form::label('username', 'Username:') ?></dt>
		<dd><?php echo form::input('username') ?></dd>
	</dl>
	<dl>
		<dt><?php echo form::label('password', 'Password:') ?></dt>
		<dd>
			<?php echo form::password('password') ?>
		</dd>
	</dl>
	<dl>
		<dt>&nbsp;</dt>
		<dd><?php echo form::label('remember', __(':checkbox Remember me', array(':checkbox' => form::checkbox('remember')))) ?></dd>
	</dl>
	
	<?php echo form::submit('login', 'Login') ?>
</fieldset>
<?php echo form::close(); ?>