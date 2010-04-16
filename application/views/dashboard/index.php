<div class="left">
	<?php echo $left ?>
</div>

<div class="right">
	<h2>History</h2>
	<ul class="no-bullets history">
		<?php foreach ( $history as $h ): ?>
		
		<li><span><?php echo Time::date($h->time, NULL) ?>:</span> <?php echo $h->history ?> </li>
		
		<?php endforeach;?>
	</ul>
</div>
