
<div class="alert alert-success">{$nb_entries} {if $nb_entries==1}{$msg_entryfound}{else}{$msg_entriesfound}{/if}</div>

{if {$size_limit_reached}}
<div class="alert alert-warning"><i class="fa fa-fw fa-exclamation-triangle"></i> {$msg_sizelimit}</div>
{/if}

<div class="row">

{foreach $entries as $entry}

    <div class="gallery {$gallery_bootstrap_column_class}{if $hover_effect} hvr-{$hover_effect}{/if}">
        <div class="panel panel-info">
            <div class="panel-body">
                <a href="index.php?page=display&dn={$entry.dn|escape:'url'}&search={$search}">
                    <img src="photo.php?dn={$entry.dn|escape:'url'}" alt="{$entry.{$attributes_map.{$gallery_title}.attribute}.0}" class="img-responsive img-thumbnail center-block" />
                </a>
            </div>
            <div class="panel-footer text-center">
                {$entry.{$attributes_map.{$gallery_title}.attribute}.0}
            </div>
        </div>
    </div>

{/foreach}

</div>
