
<div class="alert alert-success">{$nb_entries} {if $nb_entries==1}{$msg_entryfound}{else}{$msg_entriesfound}{/if}</div>

<div class="row">

{foreach $entries as $entry}

    <div class="col-sm-4">
        <div class="panel panel-info">
            <div class="panel-heading text-center">
                <p class="panel-title">
                    <i class="fa fa-{$search_result_map.{$search_result_title_id}.faclass}"></i>
                     {$entry.{$search_result_map.{$search_result_title_id}.attribute}.0}
                </p>
            </div>
            <div class="panel-body">
            {foreach $search_result_map as $id => $props}
                {if $id eq $search_result_title_id}
                    {continue}
                {/if}
                {if !({$entry.{$props.attribute}.0})}
                    {continue}
                {/if}
                {if $props.type eq 'text'}
                <p><i class="fa fa-{$props.faclass}"></i> {$entry.{$props.attribute}.0}</p>
                {/if}
                {if $props.type eq 'mailto'}
                <p><i class="fa fa-{$props.faclass}"></i> {mailto address="{$entry.{$props.attribute}.0}" encode="javascript"}</p>
                {/if}
            {/foreach}
            </div>
        </div>
    </div>

{/foreach}

</div>
