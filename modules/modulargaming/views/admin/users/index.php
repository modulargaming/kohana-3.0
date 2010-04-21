<section>
	<header>
		<nav>
			<ul>
				<li class="current"><?php echo html::anchor('admin/users', 'View') ?></li>
				<li><?php echo html::anchor('admin/users/new', 'Add new') ?></li>
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
						<td>
							<?php echo html::anchor('admin/users/edit/'.$v->id, 'Edit') ?>
							<?php echo html::anchor('admin/users/delete/'.$v->id, 'Delete') ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		
		<?php echo $pagination; ?>
		
	</div>
</section>
