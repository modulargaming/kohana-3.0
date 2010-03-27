<h2><?php echo $character->name ?> ran away</h2>

<p><?php echo $character->name ?> ran away from <?php echo $monster->name ?></p>

<?php echo html::anchor( 'dashboard', 'Go back to dashboard' ); ?><br />
<?php echo html::anchor( 'battle', 'Attack a new monster' ); ?><br />