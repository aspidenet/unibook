{extends file="template-base.tpl"}

{block name="wmcontent"}

<style>

</style>


<div id="toolbar">
	
</div>

<div style="clear:both;"></div>
<center>

    <div class="ui stackable divided grid" style="margin-top: 0px;">
        <div class="five wide column">
            
            
            <div class="ui card">
                <div class="image">
                    {if $persona.sesso == 'M'}<img src="/static/img/avatar/elliot.jpg">
                    {elseif $persona.sesso == 'F'}<img src="/static/img/avatar/molly.png">
                    {/if}
                </div>
                
                <div class="content">
                    <div class="header" style="padding-top: 25px;">{if $persona.displayname|count_characters}{$persona.displayname|strtolower|ucwords}{else}{$persona.nome|strtolower|ucwords} {$persona.cognome|strtolower|ucwords}{/if}</div>
                    <div class="meta">
                        <span class="date"><br><a href="{$APP_BASE_URL}/qualifiche/{$persona.coderuolo}">{$persona.decoruolo}</a></span>
                        {if $persona.codeprofilo|count_characters && $persona.codeprofilo != "00000000000"}<br>
                            <a href="{$APP_BASE_URL}/personale/profilo/{$persona.codeprofilo}"><span style="font-size:0.8em;">{$persona.profilo}</span></a>
                        {/if}
                    </div>
                    <div class="description" style="padding-top: 25px;">
                        <h4 class="ui horizontal divider header">Afferenza</h4>
                        <a href="{$APP_BASE_URL}/strutture/struttura/{$persona.codeugov}">{$persona.decostruttura}{*<br>
                        <span style="font-style:italic; color:#747474;">{$persona.tipo_struttura}</span>*}</a>
                
                        <h4 class="ui horizontal divider header">Contatti</h4>
                        {if $persona.email|count_characters > 0}<a href="mailto:{$persona.email}"><i class="icon mail"></i> {$persona.email}</a><br>{/if}
                        {if $persona.telefonofisso|count_characters > 0}<a href="tel:{$persona.telefonofisso}"><i class="icon phone"></i> {$persona.telefonofisso}</a>{/if}
                        {if $persona.telefonointerno|count_characters > 0}<br><span style="font-style:italic; color:#545454;"><i class="icon phone"></i> {$persona.telefonointerno}</span>{/if}
                    </div>
                </div>
            </div>


        </div>
        <div class="ten wide column" style="padding-left: 100px;">
        
            {if $persona.codessd != '000000000000' && $persona.codessd|count_characters}
            <h4 class="ui horizontal divider header">Settore Scientifico Disciplinare (SSD)</h4>
            <h3 class="ui orange" style="text-align:left;"><a href="{$APP_BASE_URL}/ssd/{$persona.codessd}">{$persona.codessd} - {$persona.decossd}</a></h3>
            {/if}
            
            {if $docenze|count}
                {assign var="anac" value=0}
                {foreach item=item key=key from=$docenze}
                    {if $anac != $item.anac}
                    <h4 class="ui horizontal divider header">Docenze {$item.anac}-{$item.anac+1}</h4>
                    {/if}
                
                    <h3 style="text-align:left;">{$item.nome_ins} (cod. {$item.codice_ins})</h3>
                    <p style="text-align:left;">
                        <span style="font-style:italic; color:#747474;">CLA in {$item.nome_cla} {if $item.classe}- classe {$item.classe}{/if}</span>
                    </p>
                    {assign var="anac" value=$item.anac}
                {foreachelse}
                {/foreach}
            {/if}
            
            {if $funzioni|count}
            <h4 class="ui horizontal divider header">Incarichi</h4>
                {foreach item=item key=key from=$funzioni}
                    <h3 style="text-align:left;">{$item.decofunzione}</h3>
                    <p style="text-align:left;">
                        <span style="font-style:italic; color:#747474;">{$item.decostruttura}</span>
                    </p>
                {foreachelse}
                {/foreach}
            {/if}
            
            <h4 class="ui horizontal divider header">Afferenza</h4>
            <h3 style="text-align:left;"><a href="{$APP_BASE_URL}/strutture/personale/{$persona.codeugov}">{$persona.decostruttura}</a></h3>
            {*<p style="text-align:left;">
                <span style="font-style:italic; color:#747474;">{$persona.tipo_struttura}</span>
            </p>*}
            {if $persona.codice_servizio|count_characters > 0}
            <h4 style="text-align:left;"><a href="{$APP_BASE_URL}/strutture/personale/{$persona.codice_servizio}">{$persona.servizio}</a></h4>
            {*<p style="text-align:left;">
                <span style="font-style:italic; color:#747474;">Servizio</span>
            </p>*}
            {/if}
            {if $persona.codice_settore|count_characters > 0}
            <h5 style="text-align:left;"><a href="{$APP_BASE_URL}/strutture/personale/{$persona.codice_settore}">{$persona.settore}</a></h5>
            {*<p style="text-align:left;">
                <span style="font-style:italic; color:#747474;">Settore</span>
            </p>*}
            {/if}
            
            {foreach name="l" item=loc from=$persona.locations}
                {if $smarty.foreach.l.first}<h4 class="ui horizontal divider header">Uffici</h4>{/if}
                {if $smarty.foreach.l.last && $item.locations|count>1}<div class="ui fitted divider"></div>{/if}
                <fieldset>
                <legend><h3 style="text-align:left;">{$loc.edificio}</h3></legend>
                <p style="text-align:left;">
                
                    <span style="font-style:italic; color:#747474;">{$loc.indirizzo}</span>
                      
                    <a href="https://maps.google.com/?q={$loc.latitudine},{$loc.longitudine}" target="_blank"> <i class="icon map"></i> Google Maps</a>
                    <br>
                    Locale: <span style="font-style:italic; color:#545454;" title="Codice del locale">{$loc.codice_locale} {$loc.locale}</span>
                </p>
                {if $colleghi[$loc.codice_locale]}
                    <p style="text-align:left;">Colleghi in stanza:<br>
                    {foreach item="coll" from=$colleghi[$loc.codice_locale]}
                        <a href="{$APP_BASE_URL}/personale/{$coll.matricola}">{$coll.cognome} {$coll.nome}</a><br>
                    {/foreach}
                    </p>
                {/if}
                </fieldset>
            {/foreach}
            
            
            
        </div>
        
    </div>




</center>



{/block}