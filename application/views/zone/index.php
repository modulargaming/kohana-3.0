<h2><?php echo $zone->name ?></h2>
<p><?php echo $zone->description ?></p>

<div class="left">
	<h3>Shops</h3>
	<?php foreach ( $shops as $shop ): ?>
	
		<?php echo html::anchor( 'shop/' . $shop->id, $shop->name ) ?>
	
	<?php endforeach ?>
</div>