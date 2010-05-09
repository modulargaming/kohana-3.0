<?php foreach($data as $i): ?>
	<li><?php echo html::anchor($i->slug, $i->title) ?></li>	
<?php endforeach ?>