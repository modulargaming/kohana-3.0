<h2>Battle</h2>

<?php echo Message::render() ?>

<div class="battle">
	<div class="left">
		<h3>You:</h3>
		
<?php
$image = 'assets/images/characters/' . $character->race->name.'/'.$character->class->name.'.png';
$image = strtolower($image);
echo html::image($image);
?>
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
				<p style="margin-top: -8px;"><?php echo $monster->level; ?></p>
			</div>
			
			<span class="bar small hp">
				<?php echo '<span style="width: ' . $m_per . '%"></span>'; ?>
				<p><?php echo $battle->hp . ' / '. $monster->max_hp; ?></p>
			</span>
		
		</div>
		
		<ul>
			<li>Attack: <span><?php echo $monster->min_dmg.' - '. $monster->max_dmg; ?></span></li>
		</ul>
	</div>
	
	<div style="clear:both;"></div>
	
	<?php
	$atk_names = array(
			'0' => "Red flux",
			'1' => "Transplant blast",
			'2' => "Dissolver",
			'3' => "Held Cutter",
			'4' => "Heated blast",
			'5' => "Inflated orb",
			'6' => "Energy mesh",
			'7' => "Energy kinesis",
			'8' => "Layered flux",
			'9' => "Delayed detonations"
		);

	foreach($atk_names as $atk_name){
		$r = rand(0, 255);
		$g = rand(0, 255);
		$b = rand(0, 255);
		$ri = 255 - $r;
		$gi = 255 - $g;
		$bi = 255 - $b;
		echo html::anchor( 'battle/attack', ' '.$atk_name.' ', array('style' => "color: rgb(".$r.",".$g.",".$b."); background-color: rgb(".$ri.",".$gi.",".$bi."); border: 1px solid black; padding: 5px;")); 
	} ?><br />
	<?php echo html::anchor( 'battle/run', 'Try to run away' ); ?><br />
	
</div>
