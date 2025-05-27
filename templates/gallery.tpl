
<div class="alert shadow alert-success">{$nb_entries} {if $nb_entries==1}{$msg_entryfound}{else}{$msg_entriesfound}{/if}</div>

{if {$size_limit_reached}}
<div class="alert shadow alert-warning"><i class="fa fa-fw fa-exclamation-triangle"></i> {$msg_sizelimit}</div>
{/if}

<div class="row">

{foreach $entries as $entry}

    <div class="gallery {$bootstrap_column_class}{if $hover_effect} hvr-{$hover_effect}{/if}">
        <div class="card mb-3 shadow card-info">
            <div class="card-body">
                <a href="index.php?page=display&dn={$entry.dn|escape:'url'}&search={$search}">
                    <img src="photo.php?dn={$entry.dn|escape:'url'}" alt="{$entry.{$attributes_map.{$card_title}.attribute}.0}" class="img-fluid mx-auto d-block" />
                </a>
            </div>
            <div class="card-footer text-center">
                {$entry.{$attributes_map.{$card_title}.attribute}.0|truncate:{$truncate_title_after}}
            </div>
        </div>
    </div>

{/foreach}

</div>
