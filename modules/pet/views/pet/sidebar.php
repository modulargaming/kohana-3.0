<?php if ( $tep->loaded() ): ?>

	<h2><?php echo $tep->name; ?></h2>
<div>
<?php echo $tep->colour->name; ?>&nbsp;
<?php echo $tep->race->name; ?>  <br />
<div class="red">Health: <?php  echo $tep->hp.'/'.$tep->max_hp ?></div>
<div class="green">Energy: <?php  echo $tep->energy.'/'.$tep->max_energy ?></div>
<div class="blue">Experience: <?php  echo $tep->xp.'/'.$tep->max_xp ?></div>
</div>
	
<?php else: ?>
<p>No Pets</p>
<?php endif; ?>
