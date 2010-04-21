<section>
	<header>
		<nav>
			<ul>
				<li class="current"><?php echo html::anchor('admin/', 'Dashboard') ?></li>
			</ul>
		</nav>
	</header>
	
	<div class="content">
		<h2>Welcome back <?php echo $user->username ?>!</h2>
	
		<p>We currently got <?php echo $users ?> registered users and <?php echo $active_users; ?> are active.</p>
	</div>
</section>
