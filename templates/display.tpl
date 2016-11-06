<div class="row">
    <div class="col-md-2 hidden-xs"></div>
    <div class="col-md-8 col-xs-12">

        <div class="panel panel-info">
            <div class="panel-heading text-center">
                <p class="panel-title">
                    <i class="fa fa-{$attributes_map.{$display_title}.faclass}"></i>
                    {$entry.{$attributes_map.{$display_title}.attribute}.0}
                </p>
            </div>

            <div class="panel-body">

                <img src="photo.php?dn={$entry.dn|escape:'url'}" alt="{$entry.{$attributes_map.{$display_title}.attribute}.0}" class="img-responsive img-thumbnail center-block" style="margin-bottom: 20px; height: {$display_photo_height};" />

                <div class="table-responsive">
                <table class="table table-striped table-hover">
                {foreach $display_items as $item}
                {$attribute=$attributes_map.{$item}.attribute}
                {$type=$attributes_map.{$item}.type}
                {$faclass=$attributes_map.{$item}.faclass}
                    {if !({$entry.$attribute.0})}
                        {continue}
                    {/if}
                    <tr>
                        <th class="text-center">
                            <i class="fa fa-{$faclass}"></i>
                        </th>
                        <th class="hidden-xs">
                            {$msg_label_{$item}}
                        </th>
                        <td>
                            {include 'value_displayer.tpl' value=$entry.{$attribute}.0 type=$type truncate_value_after=10000 ldap_params=$ldap_params}
                        </td>
                    </tr>
                {/foreach}
                </table>
                </div>

            </div>

        </div>

    </div>
    <div class="col-md-2 hidden-xs"></div>
</div>
