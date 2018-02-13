
<div class="alert alert-success">{$nb_entries} {if $nb_entries==1}{$msg_entryfound}{else}{$msg_entriesfound}{/if}</div>

{if {$size_limit_reached}}
<div class="alert alert-warning"><i class="fa fa-fw fa-exclamation-triangle"></i> {$msg_sizelimit}</div>
{/if}


<table id="directory-listing" class="table table-striped table-hover table-condensed dataTable">
<thead>
    <tr><th class="nosort">&nbsp;</th>{foreach $columns as $item}<th>{$msg_label_{$item}}</th>{/foreach}</tr>
</thead>
<tbody>
{foreach $entries as $entry}
    <tr>
        <th><a href="index.php?page=display&dn={$entry.dn|escape:'url'}&search={$search}" class="btn btn-info btn-sm" role="button" title="{$msg_displayentry}"><i class="fa fa-fw fa-id-card"></i></a></th>
    {foreach $columns as $column}
        <td>{$entry.{$attributes_map.{$column}.attribute}.0}</td>
    {/foreach}
    </tr>
{/foreach}
</tbody>
</table>

