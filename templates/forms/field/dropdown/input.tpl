<select name="{$name}" id="{$id}" {raw $html}>
    {if $field->emptyText}
        <option value="">
            {$field->emptyText}
        </option>
    {/if}
    {foreach $field->choices as $key => $name}
        <option value="{$key}" {if $key == $value}selected="selected"{/if}>
            {$name}
        </option>
    {/foreach}
</select>