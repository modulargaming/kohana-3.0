<h2><?php echo $shop->name . ' - ' . $item->name ?></h2>
<?php echo html::anchor( 'shop/' . $shop->id, 'Return to ' . $shop->name )?>

<p><?php echo $item->description?></p>

<ul>
	<li>Price: <?php echo $item->price ?></li>
	<li>Ammount in store: <?php echo $item->amount ?></li>
</ul>

<?php foreach ($errors as $v): ?>

	<?php echo $v; ?><br />

<?php endforeach; ?>

<?php echo form::open(); ?>
<fieldset>
	<dl>
		<dt style="width: 60px;">
			<?php echo form::label( 'amount', 'Amount:' ); ?><br />
		</dt>
		<dd><?php echo form::input( 'amount', '1', array( 'style' => 'width: 40px' ) ); ?></dd>
	</dl>
	<?php echo form::submit( 'buy', 'Buy' ); ?>
</fieldset>
<?php echo form::close(); ?>