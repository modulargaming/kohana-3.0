<h2><?php echo $npc->name ?></h2>

<p><?php echo $npc->message?></p>

<?php foreach($npc->messages as $m): ?>
	<?php echo html::anchor('npc/'.$npc->id.'/talk/'.$m->id, $m->title) ?><br />
<?php endforeach ?>

<?php foreach($npc->quests as $q): ?>
	<?php echo html::anchor('npc/'.$npc->id.'/quest/'.$q->id, $q->title) ?><br />
<?php endforeach ?>