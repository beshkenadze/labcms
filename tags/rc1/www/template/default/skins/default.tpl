 <form action="" method="post">
 Текущий скин: 
 {html_options name=skin_select values=$skin_select selected=$skin output=$skin_select}
 <input type="submit" value="Ok"{if !$access_edit} disabled{/if}>
</form>