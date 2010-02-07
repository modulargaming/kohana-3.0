<h2><?php echo $zone->name ?></h2>
<p><?php echo $zone->description ?></p>
 
<?php foreach ( $shops as $shop ): ?>
 
<?php echo html::anchor( 'shop/view/' . $shop->id, $shop->name ) ?>
 
<?php endforeach ?>
