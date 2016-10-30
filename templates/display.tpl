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
        </div>

        <table class="table table-striped">
        {foreach $display_items as $item}
            {$attribute=$attributes_map.{$item}.attribute}
            {$type=$attributes_map.{$item}.type}
            {$faclass=$attributes_map.{$item}.faclass}
            {if !({$entry.$attribute.0})}
                {continue}
            {/if}
            <tr>
                <th>
                    <i class="fa fa-{$faclass}"></i>
                </th>
                <th class="hidden-xs">
                    {$msg_label_{$item}}
                </th>
                {if $type eq 'text'}
                <td>{$entry.{$attribute}.0}</td>
                {/if}
                {if $type eq 'mailto'}
                <td>{mailto address="{$entry.{$attribute}.0}" encode="javascript"}</td>
                {/if}
            </tr>
        {/foreach}
        </table>

    </div>

    <div class="col-md-2 hidden-xs"></div>
</div>
