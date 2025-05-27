{foreach $entries as $entry}

    <div class="search-result {$bootstrap_column_class}{if $hover_effect} hvr-{$hover_effect}{/if}">
        <div class="card mb-3 shadow card-info">
            <div class="card-header text-center">
                <p class="card-title">
                    <i class="fa fa-fw fa-{$attributes_map.{$card_title}.faclass}"></i>
                    {$entry.{$attributes_map.{$card_title}.attribute}.0|truncate:{$truncate_title_after}}
                </p>
            </div>
            <div class="card-body">
            <div class="row">
            <div class="col-sm-4">
                {if {$type}==="user"}<img src="photo.php?dn={$entry.dn|escape:'url'}" alt="{$entry.{$attributes_map.{$card_title}.attribute}.0}" class="img-fluid mx-auto d-block" />{/if}
            </div>
            <div class="col-sm-8">
            {foreach $card_items as $item}
                {$attribute=$attributes_map.{$item}.attribute}
                {$type=$attributes_map.{$item}.type}
                {$faclass=$attributes_map.{$item}.faclass}
                {if !({$entry.$attribute.0})}
                    {if $show_undef}<p><i class="fa fa-fw fa-{$faclass}"></i> <i>{$msg_notdefined}</i></p>{/if}
                {continue}
                {/if}
                <p>
                {foreach $entry.{$attribute} as $value}
                    {if $value@index eq 0}{continue}{/if}
                    <i class="fa fa-fw fa-{$faclass}"></i>
                    {include 'value_displayer.tpl' item=$item value=$value type=$type}
                {/foreach}
                </p>
            {/foreach}
            </div>
            </div>
            </div>
            <div class="card-footer text-center">
                <a href="index.php?page=display&dn={$entry.dn|escape:'url'}&search={$search}" class="btn btn-secondary" role="button"><i class="fa fa-fw fa-id-card"></i> {$msg_displayentry}</a>
            </div>
        </div>
    </div>

{/foreach}
