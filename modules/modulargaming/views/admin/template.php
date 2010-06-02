<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Inspired by http://github.com/pilu/web-app-theme -->
	<title>Modular Gaming - <?php echo $title ?></title>
	<meta charset="utf-8" />
	
	<?php echo Asset::render('css') ?>
	
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
			if ($user) {
				echo Navigation::render('2', 'navigation/main');
			} else {
				echo Navigation::render('0','navigation/main');
			}

		?>
		<?php
			//echo '<li class="current">'.html::anchor('admin', 'Dashboard').'</li>';
			//echo '<li>'.html::anchor('admin/users', 'Users' ).'</li>';
			//echo '<li>'.html::anchor('admin/navigation', 'Navigation' ).'</li>';
		?>
		</ul>
	</nav>
</header>

<div id="content">
	
	<div class="left">
		
		<?php echo Message::render() ?>
		
		<?php echo $content ?>
	</div>
	
	<div class="right">
		
		<?php if ($latest_version > Modulargaming::VERSION): ?>
			<aside class="version">
				<header>
					<h3>New version avaible</h3>
				</header>
				<div class="content">
					<p>We have detected that a new version of Modular Gaming is avaible, <b>it is highly recomented to update!</b></p>
					<p>You are using version <b><?php echo Modulargaming::VERSION ?></b> and the latest is <b><?php echo $latest_version ?></b></p>
					<p><a href="http://modulargaming.com/">Go to download site</a></p>
				</div>
			</aside>
		<?php endif ?>
		
		<?php if ( ! empty($news)): ?>
			<aside class="news">
				<header>
					<h3>News</h3>
				</header>
				<div class="content">
					<?php foreach ($news as $n): ?>
						
						<article>
							<?php echo html::anchor($n['link'], '<h2>'.$n['title'].'</h2>') ?>
							<?php echo $n['description'] ?>
						</article>
						
					<?php endforeach ?>
				</div>
			</aside>
		<?php endif ?>
		
	</div>
	
	<footer>
		<p>Copyright © 2010 Modular Gaming.</p>
	</footer>
	
</div>
	
<?php
if (Kohana::$environment == Kohana::DEVELOPMENT)
	echo '<div id="debug">'.View::factory('profiler/stats').'</div>';
?>

<?php echo Asset::render('js') ?>

</body>
</html>
