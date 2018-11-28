{extends file="template-base.tpl"}

{block name="wmcontent"}





<div id="toolbar">
	
</div>

<div style="clear:both;"></div>
<center>

    <div class="ui stackable divided grid" style="margin-top: 0px;">
        <div class="five wide column">
            
            {*
            <div class="ui card">
                <div class="image">
                    {if $persona.sesso == 'M'}<img src="/static/img/avatar/elliot.jpg">
                    {else}<img src="/static/img/avatar/molly.png">
                    {/if}
                </div>
                
                <div class="content">
                    <div class="header" style="padding-top: 25px;">{if $persona.displayname|count_characters}{$persona.displayname|strtolower|ucwords}{else}{$persona.nome|strtolower|ucwords} {$persona.cognome|strtolower|ucwords}{/if}</div>
                    <div class="meta">
                        <span class="date"><br><a href="{$APP_BASE_URL}/ruoli/{$persona.coderuolo}">{$persona.decoruolo}</a></span>
                        {if $item.codeprofilo != '000000000000'}<br>
                            <span style="font-style:italic; color:#747474; font-size:0.8em;">{$persona.profilo}</span>
                        {/if}
                    </div>
                    <div class="description" style="padding-top: 25px;">
                        <h4 class="ui horizontal divider header">Afferenza</h4>
                        <a href="{$APP_BASE_URL}/strutture/personale/{$persona.codeugov}">{$persona.decostruttura}<br>
                        <span style="font-style:italic; color:#747474;">{$persona.tipo_struttura}</span></a>
                
                        <h4 class="ui horizontal divider header">Contatti</h4>
                        {if $persona.email|count_characters > 0}<a href="mailto:{$persona.email}"><i class="icon mail"></i> {$persona.email}</a><br>{/if}
                        {if $persona.telefonofisso|count_characters > 0}<a href="tel:{$persona.telefonofisso}"><i class="icon phone"></i> {$persona.telefonofisso}</a>{/if}
                    </div>
                </div>
            </div>
            *}
            
            
            {foreach item=funzione from=$funzioni_struttura}
                {if $incarichi.$funzione}
                    <div style="margin-bottom:15px;">
                    {foreach name="inc" item=incaricato from=$incarichi.$funzione}
                        {if $smarty.foreach.inc.first}{$incaricato["decofunzione"]|upper}{/if}
                        <br> <a href="{$APP_BASE_URL}/personale/{$incaricato['matricola']}">{$incaricato["nome"]} {$incaricato["cognome"]}</a>
                    {/foreach}
                    </div>
                {/if}
            {/foreach}
            
            <br>
            <a href="{$APP_BASE_URL}/strutture/personale/{$struttura.codeugov}" class="ui teal button">Personale di struttura</a>

        </div>
        <div class="ten wide column" style="padding-left: 100px;">
        
            <h2>{$struttura.decostruttura}</h2>
            
            <p>{$competenze}</p>
            
            {*foreach item=item key="key" from=$recapiti}
            
                {foreach item=recapito from=$item}
                        <div style="margin-bottom:15px;">
                        {$key} | {$recapito.tipo_recapito}: 
                        
                         {$recapito.recapito}
                         {$recapito.indirizzo}
                         {$recapito.cap}
                         {$recapito.localita}
                         {$recapito.comune}

                        </div>
                {/foreach}
            {/foreach*}
            
            <br>
            
            {if $recapiti.INDSD}
            <fieldset>
                <legend><h3>Indirizzo sede principale</h3></legend> 
                {foreach item=recapito from=$recapiti.INDSD}
                    <div style="text-align:left; margin-bottom:15px;">
                    {if $recapito.recapito}{$recapito.recapito}{/if}
                    {$recapito.indirizzo} <br>{$recapito.cap} {$recapito.localita} {$recapito.comune}
                    </div>
                {/foreach}
            </fieldset>
            {/if}
            
            {if $recapiti.INDAL}
            <fieldset>
                <legend><h3>Altri indirizzi</h3></legend> 
                {foreach item=recapito from=$recapiti.INDAL}
                    <div style="text-align:left; margin-bottom:15px;">
                    {if $recapito.recapito}{$recapito.recapito}{/if}
                    {$recapito.indirizzo} <br>{$recapito.cap} {$recapito.localita} {$recapito.comune}
                    </div>
                {/foreach}
            </fieldset>
            {/if}
            
            
            {if $recapiti.SITINT}
            <fieldset>
                <legend><h3>Sito internet</h3></legend> 
                {foreach item=recapito from=$recapiti.SITINT}
                    <div style="text-align:left; margin-bottom:15px;">
                        <a href="{$recapito.recapito}" target="_blank">{$recapito.recapito}</a>
                    </div>
                {/foreach}
            </fieldset>
            {/if}
            
            
            {if $recapiti.TEL}
            <fieldset>
                <legend><h3>Telefoni</h3></legend> 
                {foreach item=recapito from=$recapiti.TEL}
                    <div style="text-align:left; margin-bottom:15px;">
                        <a href="{$recapito.recapito}" target="_blank">{$recapito.recapito}</a>
                    </div>
                {/foreach}
            </fieldset>
            {/if}
            
            
            {if $recapiti.FAX}
            <fieldset>
                <legend><h3>Fax</h3></legend> 
                {foreach item=recapito from=$recapiti.FAX}
                    <div style="text-align:left; margin-bottom:15px;">
                        <a href="{$recapito.recapito}" target="_blank">{$recapito.recapito}</a>
                    </div>
                {/foreach}
            </fieldset>
            {/if}
            
            
            {if $recapiti.EMAIL}
            <fieldset>
                <legend><h3>Email</h3></legend> 
                {foreach item=recapito from=$recapiti.EMAIL}
                    <div style="text-align:left; margin-bottom:15px;">
                        <a href="{$recapito.recapito}" target="_blank">{$recapito.recapito}</a>
                    </div>
                {/foreach}
            </fieldset>
            {/if}
            
            
            <div style="margin-top: 30px;">
            
                {if $struttura.codice_area && $struttura.codeugov != $struttura.codice_area}
                AREA <a href="{$APP_BASE_URL}/strutture/struttura/{$struttura.codice_area}">{$struttura.area} (cod. {$struttura.codice_area})</a> <br>
                {/if}
                {if $struttura.codice_servizio && $struttura.codeugov != $struttura.codice_servizio}
                SERVIZIO: <a href="{$APP_BASE_URL}/strutture/struttura/{$struttura.codice_servizio}">{$struttura.servizio} (cod. {$struttura.codice_servizio})</a> <br>
                {/if}
            </div>
            
            
        
            {*if $persona.codessd != '000000000000'}
            <h4 class="ui horizontal divider header">Settore Scientifico Disciplinare (SSD)</h4>
            <h3 class="ui orange" style="text-align:left;"><a href="{$APP_BASE_URL}/ssd/{$persona.codessd}">{$persona.codessd} - {$persona.decossd}</a></h3>
            {/if}
            
            {if $docenze|count}
            <h4 class="ui horizontal divider header">Docenze</h4>
                {foreach item=item key=key from=$docenze}
                    <h3 style="text-align:left;">{$item.nome_ins} (cod. {$item.codice_ins})</h3>
                    <p style="text-align:left;">
                        <span style="font-style:italic; color:#747474;">CLA in {$item.nome_cla}</span>
                    </p>
                {foreachelse}
                {/foreach}
            {/if}
            
            {if $funzioni|count}
            <h4 class="ui horizontal divider header">Incarichi</h4>
                {foreach item=item key=key from=$funzioni}
                    <h3 style="text-align:left;">{$item.DecoFunzione}</h3>
                    <p style="text-align:left;">
                        <span style="font-style:italic; color:#747474;">{$item.DecoStruttura}</span>
                    </p>
                {foreachelse}
                {/foreach}
            {/if}
            
            <h4 class="ui horizontal divider header">Afferenza</h4>
            <h3 style="text-align:left;"><a href="{$APP_BASE_URL}/strutture/personale/{$persona.codeugov}">{$persona.decostruttura}</a></h3>
            <p style="text-align:left;">
                <span style="font-style:italic; color:#747474;">{$persona.tipo_struttura}</span>
            </p>
            {if $persona.codice_servizio|count_characters > 0}
            <h4 style="text-align:left;"><a href="{$APP_BASE_URL}/strutture/personale/{$persona.codice_servizio}">{$persona.servizio}</a></h4>
            <p style="text-align:left;">
                <span style="font-style:italic; color:#747474;">Servizio</span>
            </p>
            {/if}
            {if $persona.codice_settore|count_characters > 0}
            <h5 style="text-align:left;"><a href="{$APP_BASE_URL}/strutture/personale/{$persona.codice_settore}">{$persona.settore}</a></h5>
            <p style="text-align:left;">
                <span style="font-style:italic; color:#747474;">Settore</span>
            </p>
            {/if}
            
            {foreach name="l" item=loc from=$persona.locations}
                {if $smarty.foreach.l.first}<h4 class="ui horizontal divider header">Uffici</h4>{/if}
                {if $smarty.foreach.l.last && $item.locations|count>1}<div class="ui fitted divider"></div>{/if}
                
                <h3 style="text-align:left;">{$loc.edificio}</h3>
                <p style="text-align:left;">
                
                    <span style="font-style:italic; color:#747474;">{$loc.indirizzo}</span>
                    <a href="{$APP_BASE_URL}/spazi/planimetrie/{$loc.codice_locale}" target="_blank"> <i class="icon square"></i> Planimetria</a>
                      
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
            {/foreach*}
            
            
            
        </div>
        
    </div>




</center>



{/block}