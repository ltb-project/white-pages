<form name="advancedsearch" method="post" action="index.php?page=advancedsearch">
    {if {$advanded_search_display_search_objects}}
    <div class="row mb-3">
    <label for="type" class="col-sm-3 col-form-label text-end">{$msg_search_object}</label>
        <div class="col-sm-9">
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-fw fa-folder-open"></i></span>
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-default">
                <input type="radio" name="type" id="type" value="user" checked> <i class="fa fa-user"></i> {$msg_user_object}
                </label>
                <label class="btn btn-default">
                <input type="radio" name="type" id="type" value="group"> <i class="fa fa-group"></i> {$msg_group_object}
                </label>
                </div>
        </div>
        </div>
    </div>
    {/if}
    {foreach $advanced_search_criteria as $item}
    {$type=$attributes_map.{$item}.type}
    {$faclass=$attributes_map.{$item}.faclass}
    {include 'search_displayer.tpl' label="{$msg_label_{$item}}" item=$item type=$type faclass=$faclass ldap_params=$ldap_params list=$item_list.{$item}}
    {/foreach}
    <div class="row mb-3">
        <div class="offset-sm-3 col-sm-9">
            <button type="submit" name="submit" value="search" class="btn btn-success"><i class="fa fa-fw fa-search"></i> {$msg_search}</button>
            {if {$use_csv}}<button type="submit" name="submit" value="csv" class="btn btn-secondary"><i class="fa fa-fw fa-download"></i> {$msg_downloadcsv}</button>{/if}
        </div>
    </div>
</form>
