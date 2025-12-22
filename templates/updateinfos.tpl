<div class="update row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="card mb-3 shadow">
            <div class="card-header text-bg-secondary text-center">
                <p class="card-title">
                    <i class="fa fa-fw fa-{$attributes_map.{$card_title}.faclass}"></i>
                    {$entry.{$attributes_map.{$card_title}.attribute}.0}
                </p>
            </div>

            <form method="post">

            <input type="hidden" name="dn" value="{$dn}"/>

            <div class="card-body">

                {if $type === "user"}
                <img src="photo.php?dn={$entry.dn|escape:'url'}" alt="{$entry.{$attributes_map.{$card_title}.attribute}.0}" class="img-fluid mx-auto d-block" />
                    {if $update_photo}
                    <div class="d-grid gap-2 col-md-4 mx-auto my-3">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#updatePhotoModal">
                      <i class="fa fa-fw fa-file-image"></i> {$msg_update_photo}
                    </button>
                    {if $photo_defined}
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#deletePhotoModal">
                      <i class="fa fa-fw fa-trash"></i> {$msg_delete_photo}
                    </button>
                    {/if}
                    </div>
                    {/if}
                {/if}

                <div class="container-fluid">
                {assign var="modulo" value=0}
                {foreach $card_items as $item}
                {$attribute=$attributes_map.{$item}.attribute}
                {$type=$attributes_map.{$item}.type}
                {$faclass=$attributes_map.{$item}.faclass}
                {$multivalued=$attributes_map.{$item}.multivalued}
                {$pattern=$attributes_map.{$item}.pattern}
                {$required=0}
                {if ($attributes_map.{$item}.mandatory|is_array)}
                {if in_array('all',$attributes_map.{$item}.mandatory) or in_array('update',$attributes_map.{$item}.mandatory)}
                {$required=1}
                {/if}
                {/if}

                {if !({$entry.$attribute.0}) && ! $item|in_array:$update_items}
                    {if $modulo==0}{assign var="modulo" value=1}{else}{assign var="modulo" value=0}{/if}
                    {continue}
                {/if}

                    <div class="row align-items-center p-2{if $smarty.foreach.items.iteration % 2 == $modulo} bg-white{/if}" id="update_{$item}">
                        <div class="col-1 px-1">
                            <i class="fa fa-fw fa-{$faclass}"></i>
                        </div>
                        <div class="col-11 col-sm-3 px-1 fw-semibold">
                            {$msg_label_{$item}}
                            {if $msg_tooltip_{$item}}<span data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{$msg_tooltip_{$item}}"><i class="fa fa-fw fa-regular fa-circle-question"></i></span>{/if}
                        </div>
                        <div class="col-sm px-1">
                            {if $item|in_array:$update_items}
                                {if !({$entry.$attribute.0})}
                                {include 'value_editor.tpl' item=$item itemindex=0 value="" type=$type list=$item_list.$item multivalued=$multivalued pattern=$pattern required=$required truncate_value_after=10000}
                                {else}
                                    {foreach from=$entry.{$attribute} item=$value name=updatevalue}
                                        {include 'value_editor.tpl' item=$item itemindex=$smarty.foreach.updatevalue.index multivalued=$multivalued pattern=$pattern required=$required value=$value type=$type list=$item_list.$item truncate_value_after=10000}
                                    {/foreach}
                                {/if}
                            {else}
                                {foreach $entry.{$attribute} as $value}
                                    {include 'value_displayer.tpl' value=$value type=$type truncate_value_after=10000}
                                {/foreach}
                            {/if}
                        </div>
                    </div>
                {/foreach}
                </div>

            </div>

            <div class="card-footer text-center">
                <div class="d-grid gap-2 col-md-4 mx-auto">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-fw fa-check-square-o"></i> {$msg_submit}
                </button>
                <a href="?page=display&dn={$dn}" class="btn btn-secondary"><i class="fa fa-fw fa-cancel"></i> {$msg_cancelbacktoentry}</a>
                </div>
            </div>

            </form>

        </div>
    </div>
    <div class="col-md-2"></div>
</div>

{if $update_photo}
<div class="modal fade" id="updatePhotoModal" tabindex="-1" aria-labelledby="updatePhotoModalLabel" aria-hidden="true">
  <form method="post" enctype="multipart/form-data">
  <input type="hidden" name="dn" value="{$dn}"/>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="updatePhotoModalLabel">{$msg_update_photo}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-warning">
            {$msg_select_photo}
        </div>
        <input class="form-control" type="file" id="formFile" name="photo" accept="image/*">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="fa fa-fw fa-cancel"></i> {$msg_cancel}
        </button>
        <button type="submit" class="btn btn-success">
          <i class="fa fa-fw fa-check-square-o"></i> {$msg_submit}
        </button>
      </div>
    </div>
  </div>
  </form>
</div>
{if $photo_defined}
<div class="modal fade" id="deletePhotoModal" tabindex="-1" aria-labelledby="deletePhotoModalLabel" aria-hidden="true">
  <form method="post" enctype="multipart/form-data">
  <input type="hidden" name="dn" value="{$dn}"/>
  <input type="hidden" name="deletephoto" value="1"/>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="deletePhotoModalLabel">{$msg_delete_photo}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-warning">
            {$msg_delete_photo_warning}
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="fa fa-fw fa-cancel"></i> {$msg_no}
        </button>
        <button type="submit" class="btn btn-success">
          <i class="fa fa-fw fa-check-square-o"></i> {$msg_yes}
        </button>
      </div>
    </div>
  </div>
  </form>
</div>
{/if}
{/if}
