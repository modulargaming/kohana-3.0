        <h2>History</h2>
        <ul class="no-bullets history">
                <?php foreach ( $history as $h ): ?>

                <li><span><?php echo Time::date($h->time, NULL) ?>:</span> <?php echo $h->history ?> </li>

                <?php endforeach;?>
        </ul>

