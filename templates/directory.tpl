
<div class="alert alert-success">{$nb_entries} {if $nb_entries==1}{$msg_entryfound}{else}{$msg_entriesfound}{/if}</div>

{if {$size_limit_reached}}
<div class="alert alert-warning"><i class="fa fa-fw fa-exclamation-triangle"></i> {$msg_sizelimit}</div>
{/if}


<table id="directory-listing" class="table table-striped table-hover table-condensed dataTable">
<thead>
    <tr>
        <th class="hidden-print nosort">&nbsp;</th>
       {foreach $columns as $item}<th>{$msg_label_{$item}}</th>{/foreach}
    </tr>
</thead>
<tbody>
{foreach $entries as $entry}
    <tr>
        <th class="hidden-print">
            <a href="index.php?page=display&dn={$entry.dn|escape:'url'}&search={$search}" class="btn btn-info btn-sm" role="button" title="{$msg_displayentry}">
                <i class="fa fa-fw fa-id-card"></i>
            </a>
        </th>
    {foreach $columns as $column}
        <td>
        {$attribute=$attributes_map.{$column}.attribute}
        {if !({$entry.$attribute.0})}
            &mdash;{continue}
        {/if}
        {if in_array($column, $linkto)}
             <a href="index.php?page=display&dn={$entry.dn|escape:'url'}&search={$search}" title="{$msg_displayentry}">
        {/if}
        {foreach $entry.{$attribute} as $value}
            {if $value@index eq 0}{continue}{/if}
            {$type=$attributes_map.{$column}.type}
            {include 'value_displayer.tpl' value=$value type=$type truncate_value_after=$search_result_truncate_value_after ldap_params=$ldap_params search={$search} date_specifiers=$date_specifiers}<br />
        {/foreach}
        {if in_array($column, $linkto)}
             </a>
        {/if}
        </td>
    {/foreach}
    </tr>
{/foreach}
</tbody>
</table>

