<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0 ">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>UniBook{*$applicazione->label()*}</title>

    <script language="JavaScript" type="text/javascript" src="/static/jquery.js"></script>

    <link rel="stylesheet" type="text/css" href="/static/semantic.min.css">
    {*<link rel="stylesheet" type="text/css" href="/static/semantic-ui-tree-picker.css">*}
    <link href="https://fonts.googleapis.com/css?family=Montserrat|Open+Sans" rel="stylesheet"> 
    
    <script src="/static/semantic.min.js"></script>
    {*<script src="/static/semantic-ui-tree-picker.js"></script>*}

    <link rel="stylesheet" type="text/css" href="/static/datatables.min.css" />
    <script type="text/javascript" src="/static/datatables.min.js"></script>

</head>

<body>
{block name="html_body"}

{literal}
<script type="text/javascript">
$(document).ready(function() {
    $('.datatable').DataTable( {
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
        "pageLength": 25,
        //scrollY:        '50vh',
        //scrollCollapse: true,
        //paging:         true
        //"search": {
        //    "caseInsensitive": true
        //}
        //"order": [[ 0, 'asc' ]]
        "order": []
    } );

    // TODO Gestione del footer
    if($( window ).height() < $( document ).height()) {
        $("footer").removeClass("sticky")
    }
    else {
        $("footer").addClass("sticky")
    }

    $(window).resize(function() {
        if($( window ).height() < $( document ).height()) {
            $("footer").removeClass("sticky")
        }
        else {
            $("footer").addClass("sticky")
        }
    });
    
    
      // create sidebar and attach to menu open
      $('.ui.sidebar').sidebar('attach events', '.toc.item');
});
</script>
<style>
body {
    position: relative;
}
/*******************************************************************************
   CONTAINER
*******************************************************************************/
#bookcontainer {
	position: absolute;
    float: left;
	margin: 0px;
    margin-bottom: 50px;
	padding: 0px;
    padding-bottom: 250px;
	font-family: 'Open Sans', sans-serif;
	font-size: 1.0em;
	color:#0E2B55;
	border: 0px solid red;
	width: 100%;
    min-height: 100%;
}

/*******************************************************************************
   HEADER
*******************************************************************************/
#bookheader {
	position: relative;
    float: left;
	margin: 0px;
}


/*******************************************************************************
   CONTENT
*******************************************************************************/
#bookcontent {
	position: relative;
    float: left;

	margin: 0px;
	padding: 20px;
	width: 100%;
}

/*******************************************************************************
   MENU ORIZZONTALE
*******************************************************************************/
#bookmenu_orizzontale {
	position: relative;
    float: left;
    top: 0px;
	color: #CCC;
	background: #004d4d;
    border-bottom:16px solid #CCC;
    padding: 0px;
    width: 100%;
}
#bookmenu_orizzontale img {
		margin: 0px; 
		padding: 0px; 
		border: 1px solid red;
}
#bookmenu_orizzontale a {
		color: white;
		font : bold 10px Verdana, Geneva, Arial, Helvetica, sans-serif;
		text-decoration: none;
}
#bookmenu_orizzontale a:hover {
		color: #FFCB8C;
		text-decoration: underline;
}
#bookmenu_orizzontale a#activelink {
		color: #033;
		text-decoration: none;
}
/******************************************************************************/
#bookmenu_orizzontale #menu_group {
	float: left;
	}
/******************************************************************************/
#bookmenu_orizzontale #menu_item_first {
	float: left;
	width: 50px;
	height: 50px;
	border: 0px solid black;
	margin-right: 15px;
    margin-left: 15px;
    
    background: url("/static/img/logo-uni.png") no-repeat center top;
    background-size: auto auto;
    background-size: contain;
}
#bookmenu_orizzontale .menu_item {
    float: left;
}
#bookmenu_orizzontale .menu_item_right {
    float: right;
}
#bookmenu_orizzontale .menu_item img {
	position: relative;
	border: 0px solid yellow;
	width: 48px;
	height: 48px;
	left: 50%;
	margin-left: -24px;
}
#bookmenu_orizzontale .menu_item p {
	border: 1px solid red;
    position: relative;
    margin: auto;
    top: 0px;
    bottom: 0px;
}

/****************************************************
   FOOTER
****************************************************/
#bookfooter {
	position: absolute;
	float: left; 
    clear: both;
	width: 100%;
    background: #222;
	border: 0px solid violet;
    color: #CCC;
	bottom: 0 !important;
    padding: 10px;
}
#bookfooter p {
	margin:0px;
    padding: 10px;
	padding-top: 20px;
	position:relative;
	text-align:center;
	font-size:1em;
}

#bookfooter p a {
	color:#0E2B55;
	text-decoration:underline;
}

#bookfooter p a:hover {
	color:#0E2B55;
	text-decoration:none;
}

button {
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    border: 2px solid #369;
    color: #747474;
    background: white;
    padding: 5px 10px;
    min-width: 100px;
}
input {
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    border: 2px solid #747474;
    color: #747474;
    background: white;
    padding: 5px 10px;
}
th2 {
    text-align: center;
    font-weight: bold;
    color: red;
}
td2 {

}
.light {
    background: #dedede;
}
.dark {
    background: #a0a0a0;
}
a:hover {
    text-decoration: none !important;
}
.invisibile { display: none; }
</style>
<style type="text/css">
.toc.item {
  display: none !important;
}

@media only screen and (max-width: 700px) {
  .secondary.menu .toc.item {
    display: block !important;
    cursor: pointer !important;
  }
  .ui.container {
    width: 100%;
  }
  figure { display: inline-block; }
  #bookmenu_orizzontale nav { display: none !important; }
  #bookmenu_orizzontale { padding: 3px; }
  #bookheader { padding: 8px; }
}
</style>
{/literal}


<!-- Sidebar Menu -->
<div class="ui vertical inverted sidebar menu">
    <a class="{if $REQUEST_URI == '/'}active{/if} item" href="/">Personale</a>
    <a class="{if $REQUEST_URI == '/qualifiche'}active{/if} item" href="/qualifiche">Qualifiche</a>
    <a class="{if $REQUEST_URI == '/ssd'}active{/if} item" href="/ssd">SSD</a>
    <a class="{if $REQUEST_URI == '/incarichi'}active{/if} item" href="/incarichi">Incarichi</a>
    <a class="{if $REQUEST_URI == '/strutture'}active{/if} item" href="/strutture">Strutture</a>
    <a class="{if $REQUEST_URI == '/edifici'}active{/if} item" href="/edifici">Edifici</a>
    <a class="{if $REQUEST_URI == '/spazi'}active{/if} item" href="/spazi">Spazi</a>
</div>

<div id="bookcontainer" class="pusher">
    <header id="bookheader">
    </header>

    <div id="bookmenu_orizzontale">
        <div class="ui container">
            <div class="ui text menu">
                <div id="menu_item_first" onclick="window.location='/';"></div>
                 
                {*<a class="active item" href="{$APP_BASE_URL}/">
                    <i class="big icon search"></i> Cerca</a>
                </a>*}
                <a class="item" href="{$APP_BASE_URL}/">
                    <i class="big icon group"></i> Personale
                </a>
                <a class="item" href="{$APP_BASE_URL}/qualifiche">
                    <i class="big icon certificate"></i> Qualifiche
                </a>
                <a class="item" href="{$APP_BASE_URL}/ssd">
                    <i class="big icon bookmark"></i> SSD
                </a>
                <a class="item" href="{$APP_BASE_URL}/incarichi">
                    <i class="big icon briefcase"></i> Incarichi
                </a>
                <a class="item" href="{$APP_BASE_URL}/strutture">
                    <i class="big icon sitemap"></i> Strutture
                </a>
                <a class="item" href="{$APP_BASE_URL}/edifici">
                    <i class="big icon building"></i> Edifici
                </a>
                <a class="item" href="{$APP_BASE_URL}/spazi">
                    <i class="big icon map marker"></i> Spazi
                </a>
            </div>
        </div>
    </div>

    <div id="bookcontent">
        <div class="ui container">
            {block name="wmcontent"}{/block}
        </div>
    </div>

    <div id="bookfooter">

        {*<div class="bookfooter footer-closure">
            <div class="ui container">
            Universit&agrave; | <i>Ultimo aggiornamento: {$last_update|date_format:"%d/%m/%Y %H:%M"}</i>
            </div>
        </div>*}


        <div class="ui center aligned container">
          <div class="ui stackable inverted divided grid">
            <div class="three wide column">
              <h4 class="ui inverted header">Group 1</h4>
              <div class="ui inverted link list">
                <a href="#" class="item">Link One</a>
                <a href="#" class="item">Link Two</a>
                <a href="#" class="item">Link Three</a>
                <a href="#" class="item">Link Four</a>
              </div>
            </div>
            <div class="three wide column">
              <h4 class="ui inverted header">Group 2</h4>
              <div class="ui inverted link list">
                <a href="#" class="item">Link One</a>
                <a href="#" class="item">Link Two</a>
                <a href="#" class="item">Link Three</a>
                <a href="#" class="item">Link Four</a>
              </div>
            </div>
            <div class="three wide column">
              <h4 class="ui inverted header">Group 3</h4>
              <div class="ui inverted link list">
                <a href="#" class="item">Link One</a>
                <a href="#" class="item">Link Two</a>
                <a href="#" class="item">Link Three</a>
                <a href="#" class="item">Link Four</a>
              </div>
            </div>
            <div class="six wide column">
              <h4 class="ui inverted header">Footer Header</h4>
              <p>Extra space for a call to action inside the footer that could help re-engage users.</p>
            </div>
          </div>
          <div class="ui inverted section divider"></div>
          <!--img src="assets/images/logo.png" class="ui centered mini image"-->
          <div class="ui horizontal inverted small divided link list">
            <a class="item" href="#">2018 - Universit&agrave;</a>
            <a class="item" href="#">Site Map</a>
            <a class="item" href="#">Contact Us</a>
            <a class="item" href="#">Terms and Conditions</a>
            <a class="item" href="#">Privacy Policy</a>
          </div>
        </div>



    </div> 
</div>

{/block}
</body>
</html>
