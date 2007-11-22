{if $access_add}
<div><a href="{$smarty.server.PHP_SELF}-add.task/{$smarty.get.var1}">Добавить задачу</a></div>
{/if}
<h2>{$part_info.0.name}</h2>
    <div class="task{if $task.0.status} ready{else} notready{/if}{if $task.0.to_user_id == $user_info.user_id} it_you_task{/if}">
		
		<div class="name"><h3>{$task.0.name} [{$task.0.type}]</h3>
		{if $access_edit}<a href="{$smarty.server.PHP_SELF}-edit.task/{$task.0.todo_id}">[e]</a>{/if}
		{if $access_delete}<a href="{$smarty.server.PHP_SELF}-delete.task/{$task.0.todo_id}">[x]</a>{/if}
		  
		</div>
		<div class="text">{$task.0.descr}</div>
		<div class="status">Статус: {if $task.0.status}закончен{else}незакончен{/if}</div>
	</div>


