<input type="file" accept="{$field->getHtmlAccept()}" value="{$value}" id="{$id}" name="{$name}" {raw $html}>

{if $value}
    <a class="current-image" style="background-image: url('{$field->getSizeImage()}')" href="{$field->getOriginalImage()}"></a>
{/if}

{if $field->canClear()}
    <label for="{$id}_clear">Очистить</label>
    <input value="{$field->getClearValue()}" id="{$id}_clear" type="checkbox" name="{$name}">
{/if}
