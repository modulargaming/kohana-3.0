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
<link rel="icon" href="<?php echo url::base(); ?>/assets/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo url::base(); ?>/assets/favicon.ico" type="image/x-icon" />	
	<title>Modular Gaming - <?php echo $title; ?></title>
</head>
<body>

<div id="logo"></div>


<div id="nav">
<div class="left"></div>

<ul>
		<?php
			
			if ( $user ) {
				
				echo '<li class="no-border">' . html::anchor( 'dashboard', 'Dashboard' )    . '</li>';
				echo '<li>' . html::anchor( 'inventory', 'Inventory' ) . '</li>';
				echo '<li>' . html::anchor( 'forum', 'Forum' ) . '</li>';
				echo '<li>' . html::anchor( 'message', 'Messages' ) . '</li>';
				echo '<li>' . html::anchor( 'account', 'Settings' ) . '</li>';
				echo '<li class="no-border">' . html::anchor( 'account/logout', 'Logout' ) . '</li>';
				
			} else {
				
				echo '<li class="no-border">' . html::anchor( '', 'Home' )    . '</li>';
				echo '<li class="login">' . html::anchor( 'account/login', 'Login' ) . '</li>';
				echo '<li class="no-border">' . html::anchor( 'account/register', 'Register' ) . '</li>';
				
			}
		?>
</ul>

<div class="right"></div>
</div>

<div id="side">
<div class="content">
Side menu
</div>
</div>

<div id="wrapper">
<div class="content">
<?php echo $content; ?>
</div></div>

<div id="footer">&copy;<?php echo date('Y'); ?> Modular Gaming</div>

	

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
	if(Kohana::$environment == Kohana::DEVELOPMENT)
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
