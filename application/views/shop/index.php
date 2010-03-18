<h2><?php echo $shop->name ?></h2>
<p><?php echo $shop->description ?></p>

<div class="items">
<?php foreach ( $items as $i ): ?>
	<div class="item">
		<?php
		echo html::anchor(
			'shop/' . $shop->id . '/view/' . $i->id,
			html::image( 'assets/images/items/' . $i->image )
		)
		?>
		
		<div class="hidden">
			<h3><?php echo $i->name?></h3>
			<ul>
				<li>Price: <?php echo $i->price ?></li>
				<li>Amount: <?php echo $i->amount ?></li>
			</ul>
			<p class="description"><?php echo $i->description ?></p>
		</div>
		
		
	</div>
	
	<!--<?php echo $i->amount; ?>-->
	<!--<?php echo html::anchor( 'shop/' . $shop->id . '/view/' . $i->id, $i->name ) ?>-->

<?php endforeach ?>
</div>

<div id="buy-form" title="Buy item">
	
	<form>
		<dl>
			<dd><label>Ammount</label></dd>
			<dt><input type="text" name="ammount" /></dt>
		</dl>
	</form>
</div>