<p>Welcome to travel, please choose your destination</p>
 
<?php foreach ( $zones as $z ): ?>
 
<?php echo html::anchor( 'travel/view/' . $z->id, $z->name ); ?>
 
<?php endforeach ?>
