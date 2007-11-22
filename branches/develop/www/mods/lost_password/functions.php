<?php
/*
 * Created on 14.03.2007 9:49:58
 *
 * flex
 *
 * TODO
 *
 * (c) Александр Бешкенадзе 2007
 */
function checkEmail($email)
	{
	  // checks proper syntax
	  return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
	}
function genKey($int){
	$key = '';
		$alpha = array("a","b","c","d","e","f","g","h","i","g","k","l","m","n","o","p","q","r","s","t",
		"u","v","w","x","y","z","A","B","C","D","E","F","G","H","I","G","K","L","M","N","O","P","Q","R",
		"S","Y","U","V","W","X","Y","Z","1","2","3","4","5","6","7","8","9","0");
	for ($i=0;$i < $int;$i++) {
		$key .= $alpha[rand(0,count($alpha))];
	}
	return $key;
}
?>
