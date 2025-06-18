<div class="value_editor_container {$type} my-1 row">
  <div class="value_editor_field col-10">
{if $type eq 'text'}
    <input type="text" name="{$item}{$itemindex}" class="form-control" value="{$value}" data-role="value" />
{else if $type eq 'mailto'}
    <input type="email" name="{$item}{$itemindex}" class="form-control" value="{$value}" data-role="value" />
{else if $type eq 'tel'}
    <input type="tel" name="{$item}{$itemindex}" class="form-control" value="{$value}" data-role="value" />
{else if $type eq 'boolean'}
    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" role="switch" name="{$item}{$itemindex}" {if $value eq 'TRUE'} checked{/if} value="TRUE" data-role="value" />
    </div>
{else if $type eq 'date'}
    <input type="date" class="form-control" name="{$item}{$itemindex}" value="{convert_ldap_date($value)|date_format:"%Y-%m-%d"}" data-role="value" />
{else if $type eq 'ad_date'}
    <input type="date" class="form-control" name="{$item}{$itemindex}" value="{convert_ad_date($value)|date_format:"%Y-%m-%d"}" data-role="value" />
{else if $type eq 'static_list' or $type eq 'list'}
    <select class="form-control" name="{$item}{$itemindex}" data-role="value">
        <option></option>
        {foreach $list as $lvalue}
        <option value="{$lvalue@key}"{if {$lvalue@key}=={$value}} selected{/if}>{$lvalue}</option>
        {/foreach}
    </select>
{else if $type eq 'bytes'}
    <input type="number" name="{$item}{$itemindex}" class="form-control" value="{$value}" data-role="value" />
{else if $type eq 'dn_link'}
    <div class="dn_link_container">
    <input type="text" class="form-control" value="{get_attribute dn="{$value}" attribute="cn" ldap_url="{$ldap_params.ldap_url}" ldap_starttls="{$ldap_params.ldap_starttls}" ldap_binddn="{$ldap_params.ldap_binddn}" ldap_bindpw="{$ldap_params.ldap_bindpw}" ldap_filter="{$ldap_params.ldap_user_filter}" ldap_network_timeout="{$ldap_params.ldap_network_timeout}"}" data-role="display"/>
    <input type="hidden" name="{$item}{$itemindex}" value="{$value}" data-role="value" />
    <div class="z-3 list-group dn_link_suggestions"></div>
    </div>
{else}
    <input type="text" name={$item} class="form-control" value="{$value}" data-role="value" />
{/if}
  </div>
  <div class="value_editor_button col-2">
  {if $multivalued == "true" and $itemindex == 0}
    <button type="button" class="btn btn-success" data-action="add" data-item="{$item}"><span class="fa fa-plus"></span></button>
  {/if}
  {if $multivalued == "true" and $itemindex > 0}
    <button type="button" class="btn btn-danger" data-action="del" data-item="{$item}" data-index="{$itemindex}"><span class="fa fa-minus"></span></button>
  {/if}
  </div>
</div>
