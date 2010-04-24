<h2><?php echo __('Messages').' - '.__('Sent') ?></h2>

	<?php echo Message::render() ?>
	
	<table>
		<thead>
			<tr>
				<th><?php echo __('Title') ?></th>
				<th><?php echo __('From') ?></th>
				<th><?php echo __('Date') ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($messages as $m): ?>
			<tr>
				<td><?php echo html::anchor('message/view/'.$m->id, $m->title) ?></td>
				<td><?php echo $m->from->username ?></td>
				<td><?php echo Time::date($m->created) ?></td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	
</div>
