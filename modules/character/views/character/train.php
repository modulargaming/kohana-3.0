<h2>Train your Character</h2>

<?php echo Message::display() ?>

Welcome to the magical training centre. Train your skills here.<br /><br />


Energy:<br />
<span class="bar energy">
	<?php echo '<span style="width: ' . $char->percent_energy() . '%"></span>'; ?>
	<p><?php echo $character->energy . ' / '. $character->max_energy; ?></p>
</span>
<br />
Strength:
<?php echo $character->strength; ?>
<br />
Defence:
<?php echo $character->defence; ?>
<br />
Agility:
<?php echo $character->agility; ?>
<br />
<?php echo form::open(); ?>
<fieldset>
	<dl>
		<dt>
			<?php echo form::label('amount', 'Amount:'); ?><br />
			<span>(2 energy per skill point)</span>
		</dt>
		<dd><?php echo form::input( 'amount', 1 ); ?></dd>
	</dl>

        <dl>
                <dt>
                        <?php echo form::label( 'stat', 'Stat:' ); ?><br />
                        <span><a href="#">Summary about the stats</a></span>
                </dt>
                <dd><?php echo form::select( 'stat', $stats, $post['stat'] ); ?></dd>
        </dl>

	<br />
	<?php echo form::submit('train', 'Train'); ?>
</fieldset>
<?php echo form::close(); ?>
