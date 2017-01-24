<input type="file" accept="{$field->getHtmlAccept()}" value="{$value}" id="{$id}" name="{$name}" {raw $html}>

{if $value}
    <a href="{$field->getCurrentFileUrl()}">{$field->getCurrentFileName()}</a>
{/if}

{if $field->canClear()}
    <br/><br/>
    <input value="{$field->getClearValue()}" id="{$id}_clear" type="checkbox" name="{$name}">
    <label for="{$id}_clear">Очистить</label>
{/if}