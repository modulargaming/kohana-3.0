<?php if ( $pet->loaded() ): ?>

	<h2><?php echo $pet->name; ?></h2>
<div>
<?php echo $pet->race->name; ?> 
<?php echo $pet->class->name; ?> <br />
<div class=red><?php  echo $pet->hp.'/'.$pet->max_hp ?></div>
<div class=green><?php  echo $pet->energy.'/'.$pet->max_energy ?></div>
<div class=blue><?php  echo $pet->xp.'/'.$pet->max_xp ?></div>
</div>
	
	
<?php else: ?>
<p>No Pets</p>
<?php endif; ?>
