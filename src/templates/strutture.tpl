{extends file="template-base.tpl"}

{block name="wmcontent"}


<script type="text/javascript">
$(document).ready(function() { 
    
});
function mostra(tipo, codice) {
    $("#" + tipo + "_" + codice).toggle("invisibile");
}
</script>



    <div class="heading">
        <h1><span class="underline">Strutture</span></h1>
    </div>


    
{foreach name=i item=item from=$strutture}
	{if $smarty.foreach.i.first}
	<table class="ui striped stackable table datatable">
	<thead>
	<tr>
		<th class='centrato grassetto'>Nome</th>
		<th class='centrato grassetto'></th>
	</tr>
	</thead>
    <tbody>
	{/if}

	{cycle assign="riga" values='light,dark'}
    
	<tr class="">
		<td>
            <a href="{$APP_BASE_URL}/strutture/struttura/{$item.codeugov}">
                {$item.decostruttura} (cod. {$item.codestruttura}) 
            </a>
            <a href="{$APP_BASE_URL}/strutture/personale/{$item.codeugov}">
                <span class="ui teal label" title="{$contatori[$item.codeugov]|default:0} unit&agrave; di personale afferenti alla struttura">{$contatori[$item.codeugov]|default:0}</span> 
            </a>
            <br><span style="font-style:italic; color:#747474;">{$item.tipo_struttura}</span>
             
            
        
            <div id="servizi_{$item.codeugov}" class="invisibile" style="padding-left: 80px; padding-top: 15px;">
                <h4><i>Servizi collegati</i></h4>
                <div class="ui list">
                {foreach item="servizio" key="codice_servizio" from=$item.servizi}
                    <div class="item">
                        {*<i class="circle icon"></i>*}
                        <div class="content">
                            <div class="header">
                                <a class="item" href="{$APP_BASE_URL}/strutture/personale/{$codice_servizio}"> <span class="ui teal label" title="{$contatori[$codice_servizio]|default:0} unit&agrave; di personale afferenti al servizio">{$contatori[$codice_servizio]|default:0}</span></a>
                                <a class="item" href="{$APP_BASE_URL}/strutture/struttura/{$codice_servizio}"> {$servizio.nome} (cod. {$codice_servizio})</a>
                            </div>
                            <div class="description">
                    
                    
                                <div class="ui list">
                                {foreach item="settore" key="codice_settore" from=$servizio.settori}
                                    <div class="item">
                                        <div class="content">
                                            <i class="circle outline icon"></i> 
                                            <a class="item" href="{$APP_BASE_URL}/strutture/struttura/{$codice_settore}">{$settore.nome} (cod. {$codice_settore})</a>
                                            
                                            <a href="{$APP_BASE_URL}/strutture/personale/{$codice_settore}">
                                                <span class="ui teal label" title="{$contatori[$codice_settore]|default:0} unit&agrave; di personale afferenti al settore">{$contatori[$codice_settore]|default:0}</span>
                                            </a>
                                        </div>
                                    </div>
                                {/foreach}
                                </div>
                            </div>
                        </div>
                    </div>
                {/foreach}
                </div>
            
            
                <div id="xxxsettori_{$item.codeugov}" class="xxxinvisibile" style="padding-top: 15px;">
                    <h4><i>Settori direttamente collegati</i></h4>
                    <div class="ui list">
                    {foreach item="settore" key="codice_settore" from=$item.settori}
                        <div class="item">
                            <div class="content">
                                <i class="circle outline icon"></i>
                                <a href="{$APP_BASE_URL}/strutture/struttura/{$codice_settore}">{$settore.nome} (cod. {$codice_settore})</a> 
                                <a href="{$APP_BASE_URL}/strutture/personale/{$codice_settore}">
                                    <span class="ui teal label" title="{$contatori[$codice_settore]|default:0} unit&agrave; di personale afferenti al settore">{$contatori[$codice_settore]|default:0}</span>
                                </a>
                            </div>
                        </div>
                    {/foreach}
                    </div>
                </div>
            </div>
            
            
        
            <div id="personale_{$item.codeugov}" class="invisibile" style="padding-left: 80px; padding-top: 15px;">
                <h4><i>Personale afferente</i></h4>
                <div class="ui list">
                {foreach item="profilo" from=$personale[$item.codeugov]}
                    <div class="item">
                        <div class="content">
                            <a class="ui teal label" target="_blank" href="{$APP_BASE_URL}/strutture/personale/{$item.codeugov}/{$profilo.coderuolo}/{$profilo.codeprofilo}">{$profilo.numero}</a> {$profilo.decoruolo} {if $profilo.codeprofilo != '00000000'} | {$profilo.profilo}{/if} 
                        </div>
                    </div>
                {/foreach}
                </div>
            </div>
        </td>
        
        <td class="top aligned">
            {if $item.servizi}<button class="ui teal button" onclick="mostra('servizi', '{$item.codeugov}');">Servizi e settori</button>{/if}
            {if $personale[$item.codeugov]|count}<button class="ui teal button" onclick="mostra('personale', '{$item.codeugov}');">Personale</button>{/if}
        </td>
	</tr>

    {if $smarty.foreach.i.last}
    </tbody>
	</table>
    {/if}

{foreachelse}
<h2>Nessuna struttura.</h2>
{/foreach}




{/block}