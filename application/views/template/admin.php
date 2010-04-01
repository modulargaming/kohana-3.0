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
	
	<title>Modular Gaming</title>
</head>
<body>

	<div class="header">
		<?php echo html::anchor('', 'ModularGaming', array('class' => 'logo')); ?>
		
		<ul class="nav">
			<?php
				echo '<li class="first">' . html::anchor( 'admin', 'Dashboard' )    . '</li>';
				echo '<li>' . html::anchor( 'account', 'Settings' ) . '</li>';
				echo '<li>' . html::anchor( 'character', 'Character' ) . '</li>';
			?>
		</ul>
	</div>
	
	<div class="content">
		<?php echo $content; ?>
	</div>
	
	<div class="footer">
		<div class="wrapper">
			<p class="copyright">© 2010 the Modular Gaming Team.</p>
		</div>
	</div>
<?php
	if( Kohana::$environment == 'development' )
		echo View::factory('profiler/stats');
?>
</body>
</html>