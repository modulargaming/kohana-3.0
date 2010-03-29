<?php echo html::anchor( 'admin/users/add', 'Add user' ); ?>
<table>
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
		<?php if ( $k % 2 ): ?>
			<tr class="zebra">
		<?php else: ?>
			<tr>
		<?php endif; ?>
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
