{foreach $entries as $entry}

    <div class="search-result {$bootstrap_column_class}{if $hover_effect} hvr-{$hover_effect}{/if}">
        <div class="panel panel-info">
            <div class="panel-heading text-center">
                <p class="panel-title">
                    <i class="fa fa-fw fa-{$attributes_map.{$card_title}.faclass}"></i>
                    {$entry.{$attributes_map.{$card_title}.attribute}.0|truncate:{$truncate_title_after}}
                </p>
            </div>
            <div class="panel-body">
            <div class="row">
            <div class="col-sm-4">
                {if {$type}==="user"}<img src="photo.php?dn={$entry.dn|escape:'url'}" alt="{$entry.{$attributes_map.{$card_title}.attribute}.0}" class="img-responsive img-thumbnail center-block" />{/if}
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
                    {include 'value_displayer.tpl' value=$value type=$type}
                {/foreach}
                </p>
            {/foreach}
            </div>
            </div>
            </div>
            <div class="panel-footer text-center">
                <a href="index.php?page=display&dn={$entry.dn|escape:'url'}&search={$search}" class="btn btn-info" role="button"><i class="fa fa-fw fa-id-card"></i> {$msg_displayentry}</a>
            </div>
        </div>
    </div>

{/foreach}
