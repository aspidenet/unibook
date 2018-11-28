{extends file="template-base.tpl"}

{block name="wmcontent"}

	<div class="heading">
		<h1><span class="underline">Strutture dell'Ateneo</span></h1>
	</div>

{foreach name=i item=item key=key from=$tipi}
	{if $smarty.foreach.i.first}
	<table class="ui striped stackable table datatable">
	<thead>
	<tr>
		<th class='centrato grassetto'>Tipologia di Struttura</th>
	</tr>
	</thead>
    <tbody>
	{/if}

	{cycle assign="riga" values='light,dark'}
    
	<tr class="">
		<td><a href="{$APP_BASE_URL}/strutture/tipo-{$item.codice_tipo_struttura|strtolower}">{$item.tipo_struttura}</a></td>
	</tr>

    {if $smarty.foreach.i.last}
    </tbody>
	</table>
    {/if}

{foreachelse}
<h2>Nessuna struttura.</h2>
{/foreach}




{/block}