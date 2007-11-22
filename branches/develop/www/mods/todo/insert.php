<?php
/*
 * Created on flex 20.05.2007
 * author Beshkenadze Aleksandr a.k.a akira
 */

if($_GET["var1"] == "part") {
    $todo = $_POST["todo"];
    $todo["author"] = $user_info["login"];
    if(is_numeric($_GET["var2"])) {
    	$count=$db->selectCell("SELECT COUNT(todo_id) FROM ?_todo WHERE todo_id = ?;",$_GET["var2"]);
    	if($count) {
    		$todo['parent_id'] =  is_numeric($todo['parent_id']) ? $todo['parent_id'] : 1;
    		if($result = $db->query("UPDATE ?_todo SET ?a WHERE todo_id = ?", $todo,$_GET["var2"])){
				     refresh('OK',$_SERVER["PHP_SELF"].".".$todo['parent_id'].$config['ext']);
		      }else{
				     refresh('Не чего не изменено');
			  }
    	}
    }else{
	    if(is_numeric($todo['parent_id'])) {
	        if($result = $db->query("INSERT INTO ?_todo SET ?a", $todo)){
	        	refresh('OK');
	        }else{
	        	refresh('Не чего не изменено');
	        }
	
	    }else{
	    	exit(print_r($_POST));
	    }
    }
    
}elseif($_GET["var1"] == "task"){
	if(is_numeric($_GET["var2"])) {
		$count=$db->selectCell("SELECT COUNT(todo_id) FROM ?_todo WHERE todo_id = ?;",$_GET["var2"]);
			if($count) {
             $task = $_POST["task"];
             $task["author"] = $user_info["login"];
	         $task['task'] = 1;
	         $parent_id =  is_numeric($task['parent_id']) ? $task['parent_id'] : 1;
			 $count=$db->selectCell("SELECT COUNT(todo_id) FROM ?_todo WHERE todo_id = ?;",$parent_id);
				if($count) {
		                if($result = $db->query("UPDATE ?_todo SET ?a WHERE todo_id = ?", $task,$_GET["var2"])){
				        	refresh('OK',$_SERVER["PHP_SELF"].".$parent_id/".$_GET["var2"]);
				        }else{
				        	refresh('Не чего не изменено');
				        }
				}
			}
	}else{
		$task = $_POST["task"];
	    $task['task'] = 1;
	    $parent_id =  is_numeric($task['parent_id']) ? $task['parent_id'] : 1;
		$count=$db->selectCell("SELECT COUNT(todo_id) FROM ?_todo WHERE todo_id = ?;",$parent_id);
			if($count) {
	                if($result = $db->query("INSERT INTO ?_todo SET ?a", $task)){
			        	refresh('OK',$_SERVER["PHP_SELF"].".$parent_id/$result");
			        }else{
			        	refresh('Не чего не изменено');
			        }
			}
	}
}
?>
