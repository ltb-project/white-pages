<div class="form-group">
    <label for="{$item}" class="col-sm-3 control-label">{$label}</label>
    <div class="col-sm-9">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-fw fa-{$faclass}"></i></span>
            {if $type eq 'boolean'}
            <select class="form-control" id="{$item}" name="{$item}" placeholder="{$label}">
                <option></option>
                <option value="TRUE">{$msg_true}</option>
                <option value="FALSE">{$msg_false}</option>
            </select>
            {elseif $type eq 'date'}
            <span class="input-group-addon">{$msg_fromdate}</span>
            <input type="text" class="form-control" id="{$item}from" name="{$item}from" data-provide="datepicker" data-date-language="{$lang}">
            <span class="input-group-addon">{$msg_todate}</span>
            <input type="text" class="form-control" id="{$item}to" name="{$item}to" data-provide="datepicker" data-date-language="{$lang}">
            {elseif $type eq 'guid' or $type eq 'dn_link' or $type eq 'group_dn_link' or $type eq 'usergroup_dn_link' }
            <input type="text" class="form-control" id="{$item}" name="{$item}" placeholder="{$label}">
            {elseif $type eq 'list'}
            <select class="form-control" id="{$item}" name="{$item}" placeholder="{$label}">
                <option></option>
                {foreach $list as $value}
                <option value="{$value@key}">{$value}</option>
                {/foreach}
            </select>
            <span class="input-group-addon"><input type="checkbox" name="{$item}match" value="exact" data-toggle="popover" data-content="{$msg_exactmatch}"></span>
            {else}
            <input type="text" class="form-control" id="{$item}" name="{$item}" placeholder="{$label}">
            <span class="input-group-addon"><input type="checkbox" name="{$item}match" value="exact" data-toggle="popover" data-content="{$msg_exactmatch}"></span>
            {/if}
        </div>
    </div>
</div>
