<div class="row mb-3">
    <label for="{$item}" class="col-sm-3 col-form-label text-end">{$label}</label>
    <div class="col-sm-9">
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-fw fa-{$faclass}"></i></span>
            {if $type eq 'boolean'}
            <select class="form-control" id="{$item}" name="{$item}" placeholder="{$label}">
                <option></option>
                <option value="TRUE">{$msg_true}</option>
                <option value="FALSE">{$msg_false}</option>
            </select>
            {elseif $type eq 'date'}
            <span class="input-group-text">{$msg_fromdate}</span>
            <input type="text" class="form-control" id="{$item}from" name="{$item}from" data-provide="datepicker" data-date-language="{$lang}">
            <span class="input-group-text">{$msg_todate}</span>
            <input type="text" class="form-control" id="{$item}to" name="{$item}to" data-provide="datepicker" data-date-language="{$lang}">
            {elseif $type eq 'guid' or $type eq 'dn_link' or $type eq 'group_dn_link' or $type eq 'usergroup_dn_link' }
            <input type="text" class="form-control" id="{$item}" name="{$item}" placeholder="{$label}">
            <span class="input-group-text bg-info"><input type="checkbox" name="{$item}match" value="exact" data-bs-toggle="popover" data-bs-content="{$msg_exactmatch}"></span>
            <span class="input-group-text bg-danger"><input type="checkbox" name="{$item}negates" value="true" data-bs-toggle="popover" data-bs-content="{$msg_negates}"></span>
            {elseif $type eq 'list'}
            <select class="form-control" id="{$item}" name="{$item}" placeholder="{$label}">
                <option></option>
                {foreach $list as $value}
                <option value="{$value@key}">{$value}</option>
                {/foreach}
            </select>
            <span class="input-group-text bg-info"><input type="checkbox" name="{$item}match" value="exact" data-bs-toggle="popover" data-bs-content="{$msg_exactmatch}"></span>
            <span class="input-group-text bg-danger"><input type="checkbox" name="{$item}negates" value="true" data-bs-toggle="popover" data-bs-content="{$msg_negates}"></span>
            {elseif $type eq 'bytes'}
            <input type="number" class="form-control" id="{$item}" name="{$item}" placeholder="{$label}">
            <span class="input-group-text bg-info"><input type="checkbox" name="{$item}match" value="exact" data-bs-toggle="popover" data-bs-content="{$msg_exactmatch}"></span>
            <span class="input-group-text bg-danger"><input type="checkbox" name="{$item}negates" value="true" data-bs-toggle="popover" data-bs-content="{$msg_negates}"></span>
            {else}
            <input type="text" class="form-control" id="{$item}" name="{$item}" placeholder="{$label}">
            <span class="input-group-text bg-info"><input type="checkbox" name="{$item}match" value="exact" data-bs-toggle="popover" data-bs-content="{$msg_exactmatch}"></span>
            <span class="input-group-text bg-danger"><input type="checkbox" name="{$item}negates" value="true" data-bs-toggle="popover" data-bs-content="{$msg_negates}"></span>
            {/if}
        </div>
    </div>
</div>
