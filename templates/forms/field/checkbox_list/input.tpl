<input type="hidden" name="{$field->getHtmlBaseName()}" id="{$id}-empty" value="">
<ul class="checkbox-list">
    {foreach $field->choices as $key => $title}
        <li>
            {var $selected = $.php.is_array($value) ? $.php.in_array($key, $value) : ($key == $value)}
            <input type="checkbox" name="{$name}" id="{$id}-{$key}" value="{$key}" {if $selected}checked="checked"{/if} {raw $html}>
            <label for="{$id}-{$key}">{$title}</label>
        </li>
    {/foreach}
</ul>