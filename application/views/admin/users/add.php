<?php echo html::anchor( 'admin/users', 'Go back' ); ?>

<?php echo Message::render() ?>

<?php echo form::open(); ?>

<fieldset>
	<dl>
		<dt>
			<?php echo form::label('username', 'Username:'); ?><br />
			<span>Length must be between 3 and 20 characters.</span>
		</dt>
		<dd><?php echo form::input( 'username', $post['username'] ); ?></dd>
	</dl>
	
	<dl>
		<dt><?php echo form::label('email', 'E-mail adress:'); ?></dt>
		<dd><?php echo form::input( 'email', $post['email'] ); ?></dd>
	</dl>
	
	<dl>
		<dt>
			<?php echo form::label( 'password', 'Password:' ); ?><br />
			<span>Must be between 6 and 20 characters.</span>
		</dt>
		<dd>
			<?php echo form::password( 'password', $post['password'] ); ?>
		</dd>
	</dl>
	<dl>
		<dt><?php echo form::label('password_confirm', 'Confirm Password:'); ?></dt>
		<dd><?php echo form::password( 'password_confirm', $post['password_confirm'] ); ?></dd>
	</dl>
	
	<dl>
		<dt><?php echo form::label('role', 'Role:'); ?></dt>
		<dd><?php echo form::select( 'role', $roles ); ?></dd>
	</dl>
	
	<?php echo form::submit('add', 'Add'); ?>
</fieldset>
<?php echo form::close(); ?>