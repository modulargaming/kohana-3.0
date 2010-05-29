<?php
foreach($data as $i)
{
	if ($i->slug == Request::instance()->uri) {
		echo '<li class="current">';
	} else {
		echo '<li>';
	}
	
	echo html::anchor($i->slug, $i->title);
	
	echo '</li>';
	
}