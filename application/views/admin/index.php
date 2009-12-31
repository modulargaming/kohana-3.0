<h2>Dashboard</h2>

<p>Welcome back <?php echo $user->username; ?>, we currently got <?php echo $users; ?> registered users
 and <?php echo $active_users; ?> are active.</p>


<!-- Temp Navigation -->
<ul>
	<li><?php echo html::anchor( 'admin/users', 'Users' ); ?></li>
</ul>