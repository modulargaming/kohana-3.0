<?php if ( $tep->loaded() ): ?>

	<h2><?php echo $tep->name; ?></h2>
<div>
<?php echo $tep->race->name; ?> 
<?php echo $tep->colour->name; ?> <br />
<div class=red><?php  echo $tep->hp.'/'.$tep->max_hp ?></div>
<div class=green><?php  echo $tep->energy.'/'.$tep->max_energy ?></div>
<div class=blue><?php  echo $tep->xp.'/'.$tep->max_xp ?></div>
</div>
	
	
<?php else: ?>
<p>No Pets</p>
<?php endif; ?>
