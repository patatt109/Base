{if $field->multiple}<input type="hidden" name="{$name}" id="{$id}-empty" value="">{/if}
<select name="{$name}" id="{$id}" {if $field->multiple}multiple="multiple"{/if} {raw $html}>
    {if $field->emptyText}
        <option value="">
            {$field->emptyText}
        </option>
    {/if}
    {foreach $field->choices as $key => $name}
        {var $selected = $.php.is_array($value) ? ($key in list $value) : ($key == $value)}
        <option value="{$key}" {if $selected}selected="selected"{/if}>
            {$name}
        </option>
    {/foreach}
</select>