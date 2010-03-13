<h2><?php echo $zone->name ?></h2>
<p><?php echo $zone->description ?></p>

<div class="left">
	<h3>Shops</h3>
	<?php foreach ( $shops as $v ): ?>
	
		<?php echo html::anchor( 'shop/' . $v->id, $v->name ) ?>
	
	<?php endforeach ?>
	
	<h3>NPC</h3>
	<?php foreach ( $npcs as $v ): ?>
	
		<?php echo html::anchor( 'npc/' . $v->id, $v->name ) ?>
	
	<?php endforeach ?>
</div>