<h2><?php echo $npc->name ?></h2>

<p><?php echo $npc->message?></p>

<?php foreach($npc->messages as $m): ?>
	
	<?php echo html::anchor('npc/'.$npc->id.'/talk/'.$m->id, $m->title) ?>
	
<?php endforeach ?>