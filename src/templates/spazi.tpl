<div style="clear:both;"></div>

<p style="text-align:left;">Trovati <b>{$nlocali|number_format:0:'.':','}</b> locali per <b>{$nposti|number_format:0:'.':','}</b> posti e <b>{$nmq|number_format:0:'.':','}</b> mq.</p>

<center>
    
{foreach name=i item=item from=$spazi}
	{if $smarty.foreach.i.first}
	<table class="ui striped stackable table datatable" id="resulttable">
    <thead>
	<tr>
		{*<th class=''><i class="icon bullseye"></i> Polo</th>*}
		<th class=''><i class="icon building"></i> Edificio</th>
		<th class=''><i class="icon square"></i> Piano</th>
		<th class=''><i class="icon map marker"></i> Locale</th>
		<th class=''><i class="icon bullseye"></i> Tipologia</th>
		<th class=''><i class="icon users"></i> Capienza</th>
		<th class=''><i class="icon clock"></i> Orari</th>
	</tr>
    </thead>
    <tbody>
	{/if}

	{cycle assign="luce" values='light,dark'}
    
	<tr class="">
		{*<td>{$item.polo}</td>*}
		<td>
            {$item.edificio}<br>
            <span style="font-style:italic; color:#747474;">{$item.indirizzo}</span>
        </td>
		<td>
            {if $item.planimetria|count_characters==0}{$item.piano}
            {else}{$item.piano}<br>
            <a href="https://maps.google.com/?q={$item.latitudine},{$item.longitudine}" target="_blank"> <i class="icon map"></i> Google Maps</a>
            {/if}</td>
        
		<td>
            {$item.locale}<br>
                <span title="Codice del locale">{$item.codice_locale}</span>
            
        </td>
		<td>
            {$item.ddu}<br>
            <span style="font-style:italic; color:#747474;">{$item.categoria}</span>
            
        </td>
		<td>
            <span style="font-style:italic; color:#747474;">
            {if $item.capienza>0}{$item.capienza} posti{else}n.d.{/if}</span>
        </td>
		<td>
            <span style="font-style:italic; color:#747474;">
            {if 1} 
            <i class="icon clock outline"></i> in lavorazione{/if}</span>
        </td>
        
        

	</tr>

    {if $smarty.foreach.i.last}
    </tbody>
	</table>
    {/if}

{foreachelse}
<h2>Nessuno spazio con i filtri selezionati.</h2>
{/foreach}
</center>
