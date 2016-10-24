
<div class="alert alert-success">{$nb_entries} {if $nb_entries==1}{$msg_entryfound}{else}{$msg_entriesfound}{/if}</div>

<div class="row">

{foreach $entries as $entry}

    <div class="col-sm-4">
        <div class="panel panel-info">
            <div class="panel-heading text-center">
                <p class="panel-title"><i class="fa fa-user-circle"></i> {$entry.cn.0}</p>
            </div>
            <div class="panel-body">
                <p><i class="fa fa-user-o"></i> {$entry.uid.0}</p>
                <p><i class="fa fa-envelope-o"></i> {mailto address="{$entry.mail.0}" encode="javascript"}</p>
            </div>
        </div>
    </div>

{/foreach}

</div>
