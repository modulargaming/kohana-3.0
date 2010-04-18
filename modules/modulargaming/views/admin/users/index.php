<section id="block-view">
	<header>
		<nav>
			<ul>
				<li><a href="#block-view" class="current">View</a></li>
				<li><a href="#block-new">Add new</a></li>
			</ul>
		</nav>
	</header>
	
	<div class="content">
	
		<table id="users_table">
			<thead>
				<tr>
					<th>Id</th>
					<th>Username</th>
					<th>Email</th>
					<th>Last login</th>
					<th>Role</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $users as $k => $v ): ?>
					<tr>
						<td><?php echo $v->id ?></td>
						<td><?php echo $v->username ?></td>
						<td><?php echo $v->email ?></td>
						<td><?php echo $v->last_login ?></td>
						<td><?php echo $v->role ?></td>
						<td><?php echo html::anchor( 'admin/users/edit/' . $v->id, 'Edit') ?> Delete</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		
		<?php echo $pagination; ?>
		
	</div>
</section>

<section id="block-new">
	<header>
		<nav>
			<ul>
				<li><a href="#block-view">View</a></li>
				<li><a href="#block-new" class="current">Add new</a></li>
			</ul>
		</nav>
	</header>
	
	<div class="content">
		
		<?php echo Request::factory('admin/users/add')->execute()->response ?>
	
	</div>
</section>
