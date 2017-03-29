<ul class="radio-list">
    {foreach $field->choices as $key => $title}
        <li>
            <input type="radio" name="{$name}" id="{$id}-{$key}" value="{$key}" {if $value == $key}checked="checked"{/if} {raw $html}>
            <label for="{$id}-{$key}">{$title}</label>
        </li>
    {/foreach}
</ul>