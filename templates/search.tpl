
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
            <div class="panel-body">
            {foreach $search_result_items as $item}
                {$attribute=$attributes_map.{$item}.attribute}
                {$type=$attributes_map.{$item}.type}
                {$faclass=$attributes_map.{$item}.faclass}
                {if !({$entry.$attribute.0})}
                <p><i class="fa fa-{$faclass}"></i> <i>{$msg_notdefined}</i></p>
                {continue}
                {/if}
                {if $type eq 'text'}
                <p><i class="fa fa-{$faclass}"></i> {$entry.{$attribute}.0}</p>
                {/if}
                {if $type eq 'mailto'}
                <p><i class="fa fa-{$faclass}"></i> {mailto address="{$entry.{$attribute}.0}" encode="javascript"}</p>
                {/if}
            {/foreach}
            </div>
            <div class="panel-footer text-center">
                <a href="index.php?page=display&dn={$entry.dn|escape:'url'}" class="btn btn-info" role="button"><i class="fa fa-id-card"></i> {$msg_displayentry}</a>
            </div>
        </div>
    </div>

{/foreach}

</div>
