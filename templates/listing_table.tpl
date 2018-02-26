<!--table class="table table-striped table-hover table-condensed dataTable"-->
<thead>
    <tr>
        <th class="hidden-print nosort">&nbsp;</th>
        {foreach $listing_columns as $item}<th>{$msg_label_{$item}}</th>{/foreach}
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
    {foreach $listing_columns as $column}
        <td>
        {$attribute=$attributes_map.{$column}.attribute}
        {if ({$entry.$attribute.0})}
            {if in_array($column, $listing_linkto)}
                 <a href="index.php?page=display&dn={$entry.dn|escape:'url'}&search={$search}" title="{$msg_displayentry}">
            {/if}
            {foreach $entry.{$attribute} as $value}
                {if $value@index eq 0}{continue}{/if}
                {$type=$attributes_map.{$column}.type}
                {include 'value_displayer.tpl' value=$value type=$type}<br />
            {/foreach}
            {if in_array($column, $listing_linkto)}
                 </a>
            {/if}
        {else}
            {if $show_undef}<i>{$msg_notdefined}</i>{else}&nbsp;{/if}
        {/if}
        </td>
    {/foreach}
    </tr>
{/foreach}
</tbody>
<!--/table-->
