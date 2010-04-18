<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Inspired by http://github.com/pilu/web-app-theme -->
	<title>Modular Gaming - <?php echo $title ?></title>
	
	<?php
	foreach ($css as $style):
		echo html::style($style);
	endforeach;
	?>
	
	<script type="text/javascript">
		path = "<?php echo url::base(); ?>";
	</script>
	
	<!--[if IE]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>
<body>

<header id="header">
	<?php echo html::anchor('/admin', '<h1>Modular Gaming - '.$title.'</h1>') ?>
	<nav>
		<ul>
		<?php
			echo '<li class="current">'.html::anchor('admin', 'Dashboard')    . '</li>';
			echo '<li>'.html::anchor('admin/users', 'Users' ) . '</li>';
		?>
		</ul>
	</nav>
</header>

<div id="content">
	
	<div class="left">
		<?php echo $content ?>
	</div>
	
	<div class="right">
		
		<aside class="news">
			<header>
				<h3>News</h3>
			</header>
			<div class="content">
			
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p>
			</div>
		</aside>
		
	</div>
	
	<footer>
		<p>Copyright © 2010 Modular Gaming.</p>
	</footer>
	
</div>
	
<?php
if (Kohana::$environment == Kohana::DEVELOPMENT)
	echo '<div id="debug">'.View::factory('profiler/stats').'</div>';
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
