<h2><?php echo $shop->name ?></h2>


<?php foreach ( $items as $item ): ?>
	
	<?php echo $item->amount; ?>
	
	<?php echo html::anchor( 'shop/' . $shop->id . '/view/' . $item->id, $item->name ) ?>

<?php endforeach ?>