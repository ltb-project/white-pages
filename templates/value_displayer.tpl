{if $type eq 'text'}
    {$value|truncate:{$truncate_value_after}}
{/if}

{if $type eq 'mailto'}
    {mailto address="{$value}" encode="javascript" text="{$value|truncate:{$truncate_value_after}}"}
{/if}
