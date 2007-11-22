{if $smarty.get.var1 > 0}
		<form action="{$smarty.server.PHP_SELF}-edit.{$smarty.get.var1}{$ext}" method="post">
	{else}
		<form action="{$smarty.server.PHP_SELF}-insert{$ext}" method="post">
{/if}
<div class='mod_list'>
       {if $access_edit}
       <p>Логин: <br /><input type="text" name="user[login]" value="{$user.login}" size="40" maxlength="40"/> </p>
       <p>Пароль: <br /><input type="password" name="user[pass]" value="" size="40" maxlength="40"/> </p>
	  <p> Ввести повторно: <br /><input type="password" name="user[pass1]" value="" size="40" maxlength="40"/> </p>
       <p>email: <br /><input type="text" name="user[email]" value="{$user.email}" size="40" maxlength="40"/> </p>
       <p>Группа:<br />
			<select style="height:auto" name="user[group_id]">

			   	   {foreach from=$all_groups item=item key=key}
			   	          {if $user_group.group_id == $item.group_id}
			   	   	          <option selected value="{$item.group_id}"/>{$item.group_name}</option>
			   	          {else}
			   	              <option value="{$item.group_id}"/>{$item.group_name}</option>
			   	          {/if}
			   	   {/foreach}
			</select>
		</p>
		<p>
		Статус: <br />Активен <input {if $user.status}checked="checked"{/if} name="status" value="0" type="radio"> 
		Неактивен <input {if !$user.status}checked="checked"{/if} name="status" value="0" type="radio"> 
		</p>
	   <input type="submit" value="Сохранить" />
       {else}
       {if $user.email}{mailto text="@" address=$user.email encode="javascript"}{/if} {$user.login}
       {/if}
</div>

</form>