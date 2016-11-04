
<div class="alert alert-success">{$nb_entries} {if $nb_entries==1}{$msg_entryfound}{else}{$msg_entriesfound}{/if}</div>

<div class="row">

{foreach $entries as $entry}

    <div class="col-sm-4">
        <div class="panel panel-info">
            <div class="panel-heading text-center">
                <p class="panel-title">
                    <i class="fa fa-{$attributes_map.{$search_result_title}.faclass}"></i>
                     {$entry.{$attributes_map.{$search_result_title}.attribute}.0}
                </p>
            </div>
            <div class="panel-body" style="height: {$search_result_box_height}">
            <div class="row">
            <div class="col-sm-4">
                <img src="photo.php?dn={$entry.dn|escape:'url'}" alt="{$entry.{$attributes_map.{$display_title}.attribute}.0}" class="img-responsive img-thumbnail center-block" />
            </div>
            <div class="col-sm-8">
            {foreach $search_result_items as $item}
                {$attribute=$attributes_map.{$item}.attribute}
                {$type=$attributes_map.{$item}.type}
                {$faclass=$attributes_map.{$item}.faclass}
                {if !({$entry.$attribute.0})}
                    {if {$search_result_show_undefined}}
                    <p><i class="fa fa-{$faclass}"></i> <i>{$msg_notdefined}</i></p>
                    {/if}
                {continue}
                {/if}
                <p>
                    <i class="fa fa-{$faclass}"></i> 
                    {include 'value_displayer.tpl' value=$entry.{$attribute}.0 type=$type truncate_value_after=$search_result_truncate_value_after ldap_params=$ldap_params}
                </p>
            {/foreach}
            </div>
            </div>
            </div>
            <div class="panel-footer text-center">
                <a href="index.php?page=display&dn={$entry.dn|escape:'url'}&search={$search}" class="btn btn-info" role="button"><i class="fa fa-id-card"></i> {$msg_displayentry}</a>
            </div>
        </div>
    </div>

{/foreach}

</div>
