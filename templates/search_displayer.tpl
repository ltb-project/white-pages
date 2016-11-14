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
            {else}
            <input type="text" class="form-control" id="{$item}" name="{$item}" placeholder="{$label}">
            {/if}
        </div>
    </div>
</div>
