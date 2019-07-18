
<div class="alert alert-success">
    {$msg_title_directory} {$nb_entries} {if $nb_entries==1}{$msg_entryfound}{else}{$msg_entriesfound}{/if}
</div>

{if {$size_limit_reached}}
<div class="alert alert-warning"><i class="fa fa-fw fa-exclamation-triangle"></i> {$msg_sizelimit}</div>
{/if}

{if {$directory_display_search_objects}}
<div class="btn-group" role="group">
  <a type="button" href="index.php?page=directory&type=user" class="btn btn-default{if {$type}==="user"} active{/if}"><i class="fa fa-user"></i> {$msg_user_object}</a>
  <a type="button" href="index.php?page=directory&type=group" class="btn btn-default{if {$type}==="group"} active{/if}"><i class="fa fa-group"></i> {$msg_group_object}</a>
</div>
<hr />
{/if}

<table id="directory-listing" class="table table-striped table-hover table-condensed dataTable">
{include 'listing_table.tpl'}
</table>

