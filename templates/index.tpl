{include file="header.tpl"}

<div class="panel panel-success">
<div class="panel-body">

{include file="menu.tpl"}

{if $error}
<div class="alert alert-danger">
    <i class="fa fa-fw fa-exclamation-circle"></i> {$error}
</div>
{else}
{include file="$page.tpl"}
{/if}

</div>
</div>

{include file="footer.tpl"}
