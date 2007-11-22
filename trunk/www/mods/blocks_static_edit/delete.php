<?
$db->query("DELETE FROM ?_blocks_static WHERE block_id=?", $block_id);
refresh();
?>