<h2>Inventory</h2>

<?php foreach ( $items as $i ): ?>
	<?php echo $i->amount ?>
	<?php echo html::anchor( 'inventory/view/' . $i->id, $i->name ); ?><br />

<?php endforeach ?>
