<h2>PM - Inbox</h2>

<div class="left w150"><?php echo $sidebar ?></div>

<div class="right w500">

	<?php echo Message::render() ?>
	
	<table>
		<thead>
			<tr>
				<th>Title</th>
				<th>From</th>
				<th>Date</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($messages as $m): ?>
			<tr>
				<td><?php echo $m->title ?></td>
				<td><?php echo $m->from->username ?></td>
				<td><?php echo $m->time ?></td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	
</div>