{extends file="template-base.tpl"}

{block name="wmcontent"}

<script>

$(document).ready(function() { 
    $('.ui.dropdown').dropdown();
    $('.ui.search.dropdown').dropdown({
        fullTextSearch: 'exact'
    });
    //$('#strutture').dropdown('set selected', ['0074','0024','0073']);
    /*$('#poli').dropdown('refresh');
    $('#edifici').dropdown('refresh');
    $('#categorie').dropdown('refresh');
    $('#ddu').dropdown('refresh');
    $('#strutture').dropdown('refresh');*/
    
    $('#frmFiltroSpazi').submit(function() { // catch the form's submit event
        $.ajax({ // create an AJAX call...
            data: $(this).serialize(), // get the form data
            type: $(this).attr('method'), // GET or POST
            url: $(this).attr('action'), // the file to call
            success: function(response) { // on success..
                $('#results').html(response); // update the DIV
                $('#resulttable').DataTable( {
                    "language": {
                        "lengthMenu": "Visualizza _MENU_ record per pagina",
                        "zeroRecords": "Nessun record",
                        "info": "Pagina _PAGE_ di _PAGES_",
                        "infoEmpty": "Nessun record disponibile",
                        "infoFiltered": "(filtrate su _MAX_ record totali)",
                        "decimal": ",",
                        "thousands": ".",
                        "paginate": {
                            "first": "Prima pagina",
                            "previous": "Precedente",
                            "next": "Successiva",
                            "last": "Ultima pagina"
                        },
                        "search": "Cerca nella tabella:"
                    },
                    //scrollY:        '50vh',
                    //scrollCollapse: true,
                    //paging:         true
                    //"search": {
                    //    "caseInsensitive": true
                    //}
                    "order": [[ 0, 'asc' ]]
                } );
            }
        });
        return false; // cancel original event to prevent form submitting
    });
});

function OnEsegui_Click() {
    target = document.getElementById("results");
    target.innerHTML = "<span class='grassetto' style='padding:100px;'>Attendere...</span>";
    sync_submit('/spazi', 'frmFiltroSpazi', target);
}
</script>


    <div class="heading">
        <h1><span class="underline">Spazi dell'Ateneo</span></h1>
    </div>

    <form class="ui form" action="/spazi" method="POST" id="frmFiltroSpazi" name="frmFiltroSpazi">

        <table class="ui definition table">
            <thead></thead>
            <tbody>
                <tr>
                    <td>Edifici</td>
                    <td>
                        <select id="edifici" name="edifici[]" class="ui fluid search dropdown" multiple=''>
                            <option value="">tutti</option>
                            {foreach item="item" from=$edifici}<option value="{$item.code}">{$item.label}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Denominazione locale</td>
                    <td>
                        <div class="ui fluid input">
                            <input name="locale" placeholder="Codice o denominazione del locale, anche parziale" type="text">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Categoria locale</td>
                    <td>
                        <select id="categorie" name="categorie[]" class="ui fluid search dropdown" multiple=''>
                            <option value="">tutti</option>
                            {foreach item="item" from=$categorie}<option value="{$item.code}">{$item.label}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Tipologia locale</td>
                    <td>
                        <select id="ddu" name="ddu[]" class="ui fluid search dropdown" multiple=''>
                            <option value="">tutti</option>
                            {foreach item="item" from=$ddu}<option value="{$item.code}">{$item.label}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Struttura</td>
                    <td>
                        <select id="strutture" name="strutture[]" class="ui fluid search dropdown" multiple=''>
                            <option value="">tutte</option>
                            {foreach item="item" from=$strutture}<option value="{$item.code}">{$item.label}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <button type="submit" class="ui teal button">Cerca</button>
    </form>
    
    <div id="results"></div>




{/block}