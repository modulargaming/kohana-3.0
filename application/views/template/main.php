<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php
	foreach ($css as $style):
		echo html::style($style);
	endforeach;
	?>
	<script type="text/javascript">
		path = "<?php echo url::base(); ?>";
	</script>
	
	<title>Modular Gaming - <?php echo $title; ?></title>
</head>
<body>

<div class="header">
	<?php echo html::anchor('', 'ModularGaming', array('class' => 'logo')); ?>
	
	<ul class="nav">
		<?php
			
			if ( $user ) {
				
				echo '<li class="first">' . html::anchor( 'dashboard', 'Dashboard' )    . '</li>';
				echo '<li>' . html::anchor( 'inventory', 'Inventory' ) . '</li>';
				echo '<li>' . html::anchor( 'forum', 'Forum' ) . '</li>';
				echo '<li>' . html::anchor( 'account', 'Settings' ) . '</li>';
				echo '<li class="last">' . html::anchor( 'account/logout', 'Logout' ) . '</li>';
				
			} else {
				
				echo '<li class="first">' . html::anchor( '', 'Home' )    . '</li>';
				echo '<li class="login">' . html::anchor( 'account/login', 'Login' ) . '</li>';
				echo '<li class="last">' . html::anchor( 'account/register', 'Register' ) . '</li>';
				
			}
		?>
	</ul>
</div>

<div class="content">
	<?php echo $content; ?>
</div>

<div class="footer">
	<div class="wrapper">
		<p class="copyright">&copy; 2010 the Modular Gaming Team.</p>
	</div>
</div>

<div id="login-dialog" title="Login" class="hidden">
	<ul class="errors"></ul>
	<form>
	<fieldset class="small">
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
		
	</fieldset>
	</form>
</div>
<?php
	if( Kohana::$environment == 'development' )
		echo View::factory('profiler/stats');
?>
<?php
	foreach ($js['files'] as $script):
		echo html::script($script);
	endforeach;
	foreach ($js['scripts'] as $script):
		echo '<script type="text/javascript">'.$script.'</script>';
	endforeach;
?>
</body>
</html>
