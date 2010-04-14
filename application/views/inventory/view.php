<h2><?php echo $item->name; ?></h2>

	<?php echo $item->amount ?>
	<?php echo html::anchor( 'inventory/view/' . $item->id, $item->name ); ?><br />

