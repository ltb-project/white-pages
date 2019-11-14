<!--table class="table table-striped table-hover table-condensed dataTable"-->
<thead>
    <tr>
        <th class="hidden-print nosort">&nbsp;</th>
        {foreach $listing_columns as $item}<th>{$msg_label_{$item}}</th>{/foreach}
    </tr>
</thead>
<tbody>
{$ldap_object_type=$type}
{foreach $entries as $entry}
    <tr{if ! $listing_linkto|is_array} class="clickable" title="{$msg_displayentry}"{/if}>
        <th class="hidden-print">
            <a href="index.php?page=display&dn={$entry.dn|escape:'url'}&search={$search}" class="btn btn-info btn-sm{if $listing_linkto===false} hidden{/if}" role="button" title="{$msg_displayentry}">
                <i class="fa fa-fw fa-id-card"></i>
            </a>
            {if $ldap_object_type==='group'}
            <a href="index.php?page=gallery&groupdn={$entry.dn|escape:'url'}" class="btn btn-info btn-sm{if $listing_linkto===false} hidden{/if}" role="button" title="{$msg_gallery}">
                <i class="fa fa-fw fa-address-book"></i>
            </a>
            {/if}
        </th>
    {foreach $listing_columns as $column}
        <td>
        {$attribute=$attributes_map.{$column}.attribute}
        {if ({$entry.$attribute.0})}
            {if $listing_linkto|is_array && in_array($column, $listing_linkto)}
                 <a href="index.php?page=display&dn={$entry.dn|escape:'url'}&search={$search}" title="{$msg_displayentry}">
            {/if}
            {foreach $entry.{$attribute} as $value}
                {if $value@index eq 0}{continue}{/if}
                {$type=$attributes_map.{$column}.type}
                {include 'value_displayer.tpl' value=$value type=$type}
            {/foreach}
            {if $listing_linkto|is_array && in_array($column, $listing_linkto)}
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
