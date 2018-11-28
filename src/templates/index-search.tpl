{extends file="template-base.tpl"}

{block name="wmcontent"}

    <div class="index-search">

        <h1><span class="underline">Cerca persona</span></h1>

        <form method="GET" action="" class="ui massive form">

            <div class="field">
                <input type="text" name="nome" value="" size="60" placeholder="Puoi cercare per nome e/o cognome, interno, email, ufficio" />
            </div>

            <div class="field">
                <button class="ui teal big button" type="submit">Cerca</button>
            </div>

        </form>
    </div>

{/block}