<h2><?php echo __('Register') ?></h2>

<?php echo Message::display() ?>

<?php echo form::open( NULL, array( 'class' => 'register' ) ); ?>

<fieldset>
	<dl>
		<dt>
			<?php echo form::label('username', 'Username:'); ?><br />
			<span><?php echo __('Must be between 3 and 20 characters.') ?></span>
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
			<span><?php echo __('Must be between 6 and 20 characters.') ?></span>
		</dt>
		<dd>
			<?php echo form::password( 'password', $post['password'], array( 'maxlength' => 20 ) ); ?>
		</dd>
	</dl>
	<dl>
		<dt><?php echo form::label('password_confirm', 'Confirm password:'); ?></dt>
		<dd><?php echo form::password( 'password_confirm', $post['password_confirm'], array( 'maxlength' => 20 ) ); ?></dd>
	</dl>
	
	<dl>
		<dt><?php echo Captcha::instance()->render(); ?></dt>
		<dd><?php echo form::input( 'captcha', $post['captcha'] ); ?><br /><?php echo __('Type the characters you see in the picture.') ?></dd>
	</dl>
	
	<dl>
		<dt>&nbsp;</dt>
		<dd><?php echo form::label('tos', __(':checkbox I have read and agrees to the :tos', array( ':checkbox' => form::checkbox('tos', 'yes'), ':tos' => html::anchor('account/tos', 'Terms of Service', array( 'target' => '_blank'))))) ?></dd>
	</dl>
	
	<?php echo form::submit('register', 'Register'); ?>
</fieldset>
<?php echo form::close(); ?>
