<?php /* Hidden div for adding new users, will appear using ajax */ ?>
<div id="new">
	
	<?php
		echo form::open();
		
		
		
		
		echo form::close();
	?>
	
</div>

<table>
	<thead>
		<tr>
			<th>Id</th>
			<th>Username</th>
			<th>Email</th>
			<th>Last login</th>
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
				<td><?php echo $v->id; ?></td>
				<td><?php echo $v->username; ?></td>
				<td><?php echo $v->email; ?></td>
				<td><?php echo $v->verbose( 'last_login' ); ?></td>
				<td>Edit Delete</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php
$pag_data = array
(
	'current_page'    => array('source' => 'route', 'key' => 'id'),
	'total_items'     => $t_users,
	'items_per_page'  => 20,
);
 
echo Pagination::factory($pag_data)->render();
?>