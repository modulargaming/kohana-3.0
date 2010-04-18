<section id="block-new">
	<header>
		<nav>
			<ul>
				<li><?php echo html::anchor('admin/users', 'View') ?></li>
				<li class="current"><?php echo html::anchor('admin/users/new', 'Add new') ?></li>
			</ul>
		</nav>
	</header>
	
	<div class="content">
		
		<?php echo form::open() ?>
		
		<div class="group">
			<?php echo form::label('username', 'Username:') ?>
			<?php echo form::input('username', $post['username']) ?>
			<span class="description">Length must be between 3 and 20 characters.</span>
		</div>
		
		<div class="group">
			<?php echo form::label('email', 'E-mail adress:') ?>
			<?php echo form::input('email', $post['email']) ?>
		</div>
		
		<div class="group">
			<?php echo form::label('password', 'Password:') ?>
			<?php echo form::input('password', $post['password']) ?>
			<span class="description">Length must be between 6 and 20 characters.</span>
		</div>
		
		<div class="group">
			<?php echo form::label('password_confirm', 'Confirm password:') ?>
			<?php echo form::input('password_confirm', $post['password_confirm']) ?>
		</div>
		
		<div class="group">
			<?php echo form::label('role', 'Role:') ?>
			<?php echo form::select('role', $roles, $post['role']) ?>
		</div>
		
		<div class="buttons">
			<?php echo form::submit('add', 'Add') ?>
		</div>
		
		<?php echo form::close() ?>
	
	</div>
</section>