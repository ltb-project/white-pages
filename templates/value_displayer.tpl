{if $type eq 'text'}
    {$value|truncate:{$truncate_value_after}}
{/if}

{if $type eq 'mailto'}
    {mailto address="{$value}" encode="javascript" text="{$value|truncate:{$truncate_value_after}}"}
{/if}

{if $type eq 'dn_link'}
    {dn_link dn="{$value}" display="cn" ldap_url="{$ldap_params.ldap_url}" ldap_starttls="{$ldap_params.ldap_starttls}" ldap_binddn="{$ldap_params.ldap_binddn}" ldap_bindpw="{$ldap_params.ldap_bindpw}" ldap_user_filter="{$ldap_params.ldap_user_filter}"}
{/if}
