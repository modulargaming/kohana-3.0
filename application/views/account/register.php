<h2>Register</h2>

<?php foreach ($errors as $v): ?>

	<?php echo $v; ?><br />

<?php endforeach; ?>

<?php echo form::open( NULL, array( 'class' => 'register' ) ); ?>

<fieldset>
	<dl>
		<dt>
			<?php echo form::label('username', 'Username:'); ?><br />
			<span>Length must be between 3 and 20 characters.</span>
		</dt>
		<dd><?php echo form::input( 'username', $post['username'], array( 'maxlength' => 20 ) ); ?></dd>
	</dl>
	
	<dl>
		<dt><?php echo form::label('email', 'E-mail address:'); ?></dt>
		<dd><?php echo form::input( 'email', $post['email'] ); ?></dd>
	</dl>
	<dl>
		<dt><?php echo form::label( 'email_confirm', 'Confirm e-mail address:' ); ?></dt>
		<dd><?php echo form::input( 'email_confirm', $post['email_confirm'] ); ?></dd>
	</dl>
	
	<dl>
		<dt>
			<?php echo form::label( 'password', 'Password:' ); ?><br />
			<span>Must be between 6 and 20 characters.</span>
		</dt>
		<dd>
			<?php echo form::password( 'password', $post['password'], array( 'maxlength' => 20 ) ); ?>
		</dd>
	</dl>
	<dl>
		<dt><?php echo form::label('password_confirm', 'Confirm Password:'); ?></dt>
		<dd><?php echo form::password( 'password_confirm', $post['password_confirm'], array( 'maxlength' => 20 ) ); ?></dd>
	</dl>
	
	<dl>
		<dt><?php echo Captcha::instance()->render(); ?></dt>
		<dd><?php echo form::input( 'captcha', $post['captcha'] ); ?><br />Type the characters you see in the picture.</dd>
	</dl>
	
	<dl>
		<dt>&nbsp;</dt>
		<dd><?php echo form::label('tos', form::checkbox('tos', 'yes').'I have read and agrees to the '.html::anchor('tos', 'Terms of Service', array( 'target' => '_blank'))); ?></dd>
	</dl>
	
	<?php echo form::submit('register', 'Register'); ?>
</fieldset>
<?php echo form::close(); ?>
