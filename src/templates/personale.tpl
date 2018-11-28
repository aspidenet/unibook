{extends file="template-base.tpl"}

{block name="wmcontent"}


    <div class="heading">
        <h1><span class="underline">Personale di Ateneo</span></h1>
    </div>

    
{foreach name=i item=item from=$personale}
	{if $smarty.foreach.i.first}
	<table class="ui striped stackable table datatable">
    <thead>
	<tr>
		<th class=''><i class="icon user"></i> Nome</th>
		<th class=''><i class="icon certificate"></i> Qualifica</th>
		<th class=''><i class="icon sitemap"></i> Afferenza</th>
		<th class=''><i class="icon briefcase"></i> Incarichi</th>
		{*<th class=''><i class="icon bullseye"></i> Polo</th>*}
		<th class=''><i class="icon building"></i> Edificio</th>
		<th class=''><i class="icon mail"></i> Contatti</th>

	</tr>
    </thead>
    <tbody>
	{/if}

	{cycle assign="luce" values='light,dark'}
    
	<tr class="">
		<td><a href="{$APP_BASE_URL}/personale/{$item.matricola}">{if $item.displayname|count_characters}{$item.displayname|strtolower|ucwords}{else}{$item.nome|strtolower|ucwords} {$item.cognome|strtolower|ucwords}{/if}</a></td>
		<td><a href="{$APP_BASE_URL}/qualifiche/{$item.coderuolo}">{$item.decoruolo}</a>
            {if $item.codessd|count_characters && $item.codessd != '000000000000'}<br>
                <span style="font-style:italic; color:#747474; font-size:0.8em;">Settore Scientifico Disciplinare</span><br>
                <a href="{$APP_BASE_URL}/ssd/{$item.codessd}">{$item.codessd} - {$item.decossd}</a>
            {/if}
            {if $item.codeprofilo != '000000000000'}<br>
                <a href="{$APP_BASE_URL}/personale/profilo/{$item.codeprofilo}"><span style="font-size:0.8em;">{$item.profilo}</span></a>
            {/if}
        </td>
		<td>
            <a href="{$APP_BASE_URL}/strutture/struttura/{$item.codeugov}">
            {$item.decostruttura}{*<br>
            <span style="font-style:italic; color:#747474;">{$item.tipo_struttura}</span>*}</a>
            
            {if $item.codice_servizio}
            <div style="font-size:0.9em;">
                <a href="{$APP_BASE_URL}/strutture/struttura/{$item.codice_servizio}">
                {$item.servizio}{*<br>
                <span style="font-style:italic; color:#747474;">Servizio</span>*}</a>
            </div>
            {/if}
            
            {if $item.codice_settore}
            <div style="font-size:0.8em;">
                <a href="{$APP_BASE_URL}/strutture/struttura/{$item.codice_settore}">
                {$item.settore}{*<br>
                <span style="font-style:italic; color:#747474;">Settore</span>*}</a>
            </div>
            {/if}
            
        </td>
		<td>
            {foreach name="l" item=fun from=$item.assignments}
                {if $smarty.foreach.l.last && $item.assignments|count>1}<div class="ui fitted divider"></div>{/if}
                
            <a href="{$APP_BASE_URL}/incarichi/{$fun.codefunzione}">{$fun.decofunzione}</a>
            <br>
            <a href="{$APP_BASE_URL}/strutture/struttura/{$fun.codestrutturafunzione}">
                <span style="font-style:italic; color:#747474;">{$fun.decostrutturafunzione}</span>
            </a>
            {foreachelse}
            <span style="font-style:italic; color:#747474;">-</span>
            {/foreach}
        </td>
		{*<td>
            {if $item.codice_locale|count_characters>0}
            <a href="{$APP_BASE_URL}/poli/{$item.codice_polo}">{$item.polo}</a>
            {else}
            <span style="font-style:italic; color:#747474;">(non localizzato)</span>
            {/if}
        </td>*}
		<td>
            {foreach name="l" item=loc from=$item.locations}
                {if $smarty.foreach.l.last && $item.locations|count>1}<div class="ui fitted divider"></div>{/if}
                
            <a href="{$APP_BASE_URL}/edifici/{$loc.codice_edificio}">{$loc.edificio}<br>
                <span style="font-style:italic; color:#747474;">{$loc.indirizzo}</span>
            </a> 
            <br>
               
            <a href="https://maps.google.com/?q={$loc.latitudine},{$loc.longitudine}" target="_blank"> <i class="icon map"></i> Google Maps</a>
            <br>
            <span style="font-style:italic; color:#545454;" title="Codice del locale">{$loc.codice_locale} - {$loc.locale}</span>
            {foreachelse}
            <span style="font-style:italic; color:#747474;">(non localizzato)</span>
            {/foreach}
        </td>
		<td>
            {if $item.email|count_characters > 0}<a href="mailto:{$item.email}"><i class="icon mail"></i> {$item.email}</a><br>{/if}
            {if $item.telefonofisso|count_characters > 0}<a href="tel:{$item.telefonofisso}"><i class="icon phone"></i> {$item.telefonofisso}</a>{/if}
            {if $item.telefonointerno|count_characters > 0}<br><span style="font-style:italic; color:#545454;"><i class="icon phone"></i> {$item.telefonointerno}</span>{/if}
        </td>

    
		
	</tr>

    {if $smarty.foreach.i.last}
    </tbody>
	</table>
    {/if}

{foreachelse}
<h2>Nessuna persona.</h2>
{/foreach}




{/block}