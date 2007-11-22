
<div><a href="{$smarty.server.PHP_SELF}-add.task/{$smarty.get.var1}">Добавить задачу</a></div>

    <h2>{$part_info.0.name}</h2>
    {foreach from=$task_list item=task key=key}
	<div class="task{if $task.status} ready{else} notready{/if}{if $task.to_user_id == $user_info.user_id} it_you_task{/if}">
		<div class="name"><h3><a href="{$smarty.server.PHP_SELF}.{$smarty.get.var1}/{$task.todo_id}">{$task.name}</a> [{$task.type}]</h3>
		</div>
	</div>
	 {/foreach}

