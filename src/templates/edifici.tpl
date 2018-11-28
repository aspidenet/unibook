{extends file="template-base.tpl"}

{block name="wmcontent"}


	<div class="heading">
		<h1><span class="underline">Edifici</span></h1>
	</div>

    
{foreach name=i item=item from=$edifici}
	{if $smarty.foreach.i.first}
	<table class="ui striped stackable celled table datatable">
	<thead>
	<tr>
		{*<th class='centrato grassetto'><a class="nero" href="">Polo</a></th>*}
		<th class='centrato grassetto'>Edificio</th>
		<th class='centrato grassetto'>Indirizzo</th>
	</tr>
	</thead>
    <tbody>
	{/if}

	{cycle assign="riga" values='light,dark'}
    
	<tr class="">
		{*<td><a href="{$APP_BASE_URL}/poli/{$item.codice_polo}">{$item.polo|default:'-'}</a> {$item.numero}</td>*}
		<td><a href="{$APP_BASE_URL}/edifici/{$item.codice_edificio}">{*$item.codice_edificio*} {$item.edificio}</a></td>
		<td>{$item.indirizzo}</td>
		
    
		
	</tr>

    {if $smarty.foreach.i.last}
    </tbody>
	</table>
    {/if}

{foreachelse}
<h2>Nessun edificio.</h2>
{/foreach}




{/block}