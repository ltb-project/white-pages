<div class="row">
    <div class="col-md-2 hidden-xs"></div>
    <div class="display col-md-8 col-xs-12">

        <div class="card mb-3 shadow card-info">
            <div class="card-header text-center">
                <p class="card-title">
                    <i class="fa fa-fw fa-{$attributes_map.{$card_title}.faclass}"></i>
                    {$entry.{$attributes_map.{$card_title}.attribute}.0}
                </p>
            </div>

            <div class="card-body">

                {if $type === "user"}
                <img src="photo.php?dn={$entry.dn|escape:'url'}" alt="{$entry.{$attributes_map.{$card_title}.attribute}.0}" class="img-fluid mx-auto d-block" />
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
                            {include 'value_displayer.tpl' item=$item value=$value type=$type truncate_value_after=10000}
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
{if {$use_vcard} || {$use_updateinfos and $dn == $userdn}}
            <div class="card-footer text-center">
{if {$use_vcard}}
                <a href="index.php?page=display&dn={$entry.dn|escape:'url'}&search={$search}&vcard=1" class="btn btn-secondary" role="button"><i class="fa fa-fw fa-download"></i> {$msg_downloadvcard}</a>
{/if}
{if {$use_updateinfos and $dn == $userdn}}
                <a href="index.php?page=updateinfos" class="btn btn-secondary" role="button"><i class="fa fa-fw fa-edit"></i> {$msg_editentry}</a>
{/if}
            </div>

{/if}
        </div>

    </div>
    <div class="col-md-2 hidden-xs"></div>
</div>
