{extends file="template-base.tpl"}

{block name="wmcontent"}

	<div class="heading">
		<h1><span class="underline">Qualifiche</span></h1>
	</div>

    
{foreach name=i item=item from=$qualifiche}
	{if $smarty.foreach.i.first}
	<table class="ui striped stackable table datatable">
	<thead>
	<tr>
		<th class='centrato grassetto'>Nome</th>
	</tr>
	</thead>
    <tbody>
	{/if}

	{cycle assign="riga" values='light,dark'}
    
	<tr class="">
    
		<td>
            <a href="{$APP_BASE_URL}/qualifiche/{$item.coderuolo}">{$item.decoruolo} 
            </a> 
        </td>
	</tr>

    {if $smarty.foreach.i.last}
    </tbody>
	</table>
    {/if}

{foreachelse}
<h2>Nessuna qualifica.</h2>
{/foreach}

{/block}