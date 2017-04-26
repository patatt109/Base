<input type="file" accept="{$field->getHtmlAccept()}" value="{$value}" id="{$id}" name="{$name}" {raw $html}>

{if $value}
    <a class="current-image" href="{$field->getOriginalImage()}" target="_blank">
        <img src="{$field->getOriginalImage()}" alt="">
    </a>
{/if}

{if $field->canClear()}
    <input value="{$field->getClearValue()}" id="{$id}_clear" type="checkbox" name="{$name}">
    <label for="{$id}_clear" class="clear-file">Очистить</label>
{/if}