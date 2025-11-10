{include file="header.tpl"}

<div class="card mb-3 shadow card-success">
<div class="card-body">

{include file="menu.tpl"}

{if $error}
{include file="error_message.tpl"}
{/if}

{include file="$page.tpl"}

</div>
</div>

{include file="footer.tpl"}
