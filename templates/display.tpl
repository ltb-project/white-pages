<div class="row">
    <div class="col-md-2 hidden-xs"></div>
    <div class="display col-md-8 col-xs-12">

        <div class="panel panel-info">
            <div class="panel-heading text-center">
                <p class="panel-title">
                    <i class="fa fa-fw fa-{$attributes_map.{$card_title}.faclass}"></i>
                    {$entry.{$attributes_map.{$card_title}.attribute}.0}
                </p>
            </div>

            <div class="panel-body">

                {if $type === "user"}
                <img src="photo.php?dn={$entry.dn|escape:'url'}" alt="{$entry.{$attributes_map.{$card_title}.attribute}.0}" class="img-responsive img-thumbnail center-block" />
                {/if}

                <div class="table-responsive">
                <table class="table table-striped table-hover">
                {foreach $card_items as $item}
                {$attribute=$attributes_map.{$item}.attribute}
                {$type=$attributes_map.{$item}.type}
                {$faclass=$attributes_map.{$item}.faclass}

                {if !({$entry.$attribute.0}) && ! $show_undef}
                    {continue}
                {/if}
                    <tr>
                        <th class="text-center">
                            <i class="fa fa-fw fa-{$faclass}"></i>
                        </th>
                        <th class="hidden-xs">
                            {$msg_label_{$item}}
                        </th>
                        <td>
                        {if ({$entry.$attribute.0})}
                            {foreach $entry.{$attribute} as $value}
                            {if $value@index ne 0}
                            {include 'value_displayer.tpl' value=$value type=$type truncate_value_after=10000}
                            {/if}
                            {/foreach}
                        {else}
                            <i>{$msg_notdefined}</i><br />
                        {/if}
                        </td>
                    </tr>
                {/foreach}
                </table>
                </div>

            </div>
{if {$use_vcard}}
            <div class="panel-footer text-center">
                <a href="index.php?page=display&dn={$entry.dn|escape:'url'}&search={$search}&vcard=1" class="btn btn-info" role="button"><i class="fa fa-fw fa-download"></i> {$msg_downloadvcard}</a>
            </div>

{/if}
        </div>

    </div>
    <div class="col-md-2 hidden-xs"></div>
</div>
