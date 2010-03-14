<h2>Register</h2>

<?php echo Message::display() ?>

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
		<dt>
			<?php echo form::label('email', 'E-mail address:'); ?><br />
			<span>Optional</span>
		</dt>
		<dd><?php echo form::input( 'email', $post['email'] ); ?></dd>
	</dl>
	
	<dl>
		<dt>&nbsp;</dt>
		<dd><?php echo form::label('tos', form::checkbox('tos', 'yes').'I have read and agrees to the '.html::anchor('account/tos', 'Terms of Service', array( 'target' => '_blank'))); ?></dd>
	</dl>
	
	<?php echo form::submit('register', 'Register'); ?>
</fieldset>
<?php echo form::close(); ?>
