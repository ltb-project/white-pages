{if $type eq 'text'}
    {$value|truncate:{$truncate_value_after}}<br />
{/if}

{if $type eq 'mailto'}
    {mailto address="{$value|escape:"html"}" encode="javascript" text="{$value|truncate:{$truncate_value_after}}" extra='class="link-email" title="'|cat:$msg_tooltip_emailto:'"'}<br />
{/if}

{if $type eq 'tel'}
    <a href="tel:{$value}" rel="nofollow" class="link-phone" title="{$msg_tooltip_phoneto}">{$value|truncate:{$truncate_value_after}}</a><br />
{/if}

{if $type eq 'dn_link'}
    {assign var="link" value="{{get_attribute dn="{$value}" attribute="cn" ldap_url="{$ldap_params.ldap_url}" ldap_starttls="{$ldap_params.ldap_starttls}" ldap_binddn="{$ldap_params.ldap_binddn}" ldap_bindpw="{$ldap_params.ldap_bindpw}" ldap_filter="{$ldap_params.ldap_user_filter}" ldap_network_timeout="{$ldap_params.ldap_network_timeout}"}|truncate:{$truncate_value_after}}"}
    {if $link}
    <a href="index.php?page=display&dn={$value|escape:'url'}&search={$search}">{$link}</a><br />
    {/if}
{/if}

{if $type eq 'group_dn_link'}
    {assign var="link" value="{{get_attribute dn="{$value}" attribute="cn,description" ldap_url="{$ldap_params.ldap_url}" ldap_starttls="{$ldap_params.ldap_starttls}" ldap_binddn="{$ldap_params.ldap_binddn}" ldap_bindpw="{$ldap_params.ldap_bindpw}" ldap_filter="{$ldap_params.ldap_group_filter}" ldap_network_timeout="{$ldap_params.ldap_network_timeout}"}|truncate:{$truncate_value_after}}"}
    {if $link}
    <a href="index.php?page=display&dn={$value|escape:'url'}&search={$search}">{$link}</a><br />
    {/if}
{/if}

{if $type eq 'usergroup_dn_link'}
    {assign var="link" value="{{get_attribute dn="{$value}" attribute="cn,description" ldap_url="{$ldap_params.ldap_url}" ldap_starttls="{$ldap_params.ldap_starttls}" ldap_binddn="{$ldap_params.ldap_binddn}" ldap_bindpw="{$ldap_params.ldap_bindpw}" ldap_filter="(|{$ldap_params.ldap_group_filter}{$ldap_params.ldap_user_filter})" ldap_network_timeout="{$ldap_params.ldap_network_timeout}"}|truncate:{$truncate_value_after}}"}
    {if $link}
    <a href="index.php?page=display&dn={$value|escape:'url'}&search={$search}">{$link}</a><br />
    {/if}
{/if}

{if $type eq 'boolean'}
    {if $value=="TRUE"}{$msg_true|truncate:{$truncate_value_after}}<br />{/if}
    {if $value=="FALSE"}{$msg_false|truncate:{$truncate_value_after}}<br />{/if}
{/if}

{if $type eq 'date'}
    {convert_ldap_date($value)|date_format:{$date_specifiers}|truncate:{$truncate_value_after}}<br />
{/if}

{if $type eq 'guid'}
    {convert_guid_value($value)|truncate:{$truncate_value_after}}<br />
{/if}

{if $type eq 'list'}
    {{get_list_value value=$value ldap_url="{$ldap_params.ldap_url}" ldap_starttls="{$ldap_params.ldap_starttls}" ldap_binddn="{$ldap_params.ldap_binddn}" ldap_bindpw="{$ldap_params.ldap_bindpw}" ldap_network_timeout="{$ldap_params.ldap_network_timeout}" list_base="{$attributes_list.{$item}.base}" list_filter="{$attributes_list.{$item}.filter}" list_key="{$attributes_list.{$item}.key}" list_value="{$attributes_list.{$item}.value}" }|truncate:{$truncate_value_after}}<br />
{/if}

{if $type eq 'bytes'}
    {convert_bytes($value)|truncate:{$truncate_value_after}}<br />
{/if}

{if $type eq 'address'}
    {foreach split_value($value,'$') as $fragment}
    {$fragment|truncate:{$truncate_value_after}}<br />
    {/foreach}
{/if}
