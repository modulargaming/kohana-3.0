<h2>Battle</h2>

<?php echo Message::render() ?>

<div class="battle">
	<div class="left">
		<h3>You:</h3>
		
		<span class="bar hp">
			<?php echo '<span style="width: ' . $char->percent_hp() . '%"></span>'; ?>
			<p><?php echo $character->hp . ' / '. $character->max_hp; ?></p>
		</span>
		
	</div>
	
	<div class="right">
			
		<?php echo html::image( 'assets/images/monsters/' . $monster->image, array( 'class' => 'npc' ) ) ?>
		<?php
			$m_per = $char->percent_hp($battle->hp, $monster->max_hp);
		?>
		
		<div class="right">
			<div style="text-align: center;">
				<h2><?php echo $monster->name; ?></h2>
				<p style="margin-top: -8px;">Level 1</p>
			</div>
			
			<span class="bar small hp">
				<?php echo '<span style="width: ' . $m_per . '%"></span>'; ?>
				<p><?php echo $battle->hp . ' / '. $monster->max_hp; ?></p>
			</span>
		
		</div>
		
		<ul>
			<li>Attack: <span>5 - 10</span></li>
		</ul>
	</div>
	
	<div style="clear:both;"></div>
	
	<?php echo html::anchor( 'battle/attack', 'Attack' ); ?><br />
	<?php echo html::anchor( 'battle/run', 'Try to run away' ); ?><br />
	
</div>
