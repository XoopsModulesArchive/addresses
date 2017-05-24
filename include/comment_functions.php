<?php
// comment callback functions

function addresses_com_update($link_id, $total_num)
	{
	$db = Database::getInstance();
	$sql = 'UPDATE '.$db->prefix('addresses_addresses').' SET comments = '.$total_num.' WHERE aid = '.$link_id;
	$db->query($sql);
	}


function addresses_com_approve(&$comment)
	{
	// notification mail here
	}
?>
