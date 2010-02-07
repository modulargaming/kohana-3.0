<h2>Travel to <?php echo $zone->name; ?></h2>
<p><?php echo $zone->description; ?></p>
 
<p>To travel to <?php echo $zone->name; ?> you will require <i><?php echo $zone->energy; ?></i> energy.</p>
 
<?php echo html::anchor( 'travel/travel/' . $zone->id, 'Travel to ' . $zone->name ); ?>
