<?php
/* Smarty version 3.1.33, created on 2018-11-29 00:01:47
  from '/var/www/unibook/src/templates/template-base.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5bff1e5b8ff612_07211934',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6a52bee062f8f2862bc9351c063dfdcbde6a17a1' => 
    array (
      0 => '/var/www/unibook/src/templates/template-base.tpl',
      1 => 1543430610,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5bff1e5b8ff612_07211934 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>
<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0 ">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>UniBook</title>

    <?php echo '<script'; ?>
 language="JavaScript" type="text/javascript" src="/static/jquery.js"><?php echo '</script'; ?>
>

    <link rel="stylesheet" type="text/css" href="/static/semantic.min.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat|Open+Sans" rel="stylesheet"> 
    
    <?php echo '<script'; ?>
 src="/static/semantic.min.js"><?php echo '</script'; ?>
>
    
    <link rel="stylesheet" type="text/css" href="/static/datatables.min.css" />
    <?php echo '<script'; ?>
 type="text/javascript" src="/static/datatables.min.js"><?php echo '</script'; ?>
>

</head>

<body>
<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_14618269175bff1e5b8e1212_13649191', "html_body");
?>

</body>
</html>
<?php }
/* {block "wmcontent"} */
class Block_6173956705bff1e5b8f2a67_26839724 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block "wmcontent"} */
/* {block "html_body"} */
class Block_14618269175bff1e5b8e1212_13649191 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'html_body' => 
  array (
    0 => 'Block_14618269175bff1e5b8e1212_13649191',
  ),
  'wmcontent' => 
  array (
    0 => 'Block_6173956705bff1e5b8f2a67_26839724',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>



<?php echo '<script'; ?>
 type="text/javascript">
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
<?php echo '</script'; ?>
>
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



<!-- Sidebar Menu -->
<div class="ui vertical inverted sidebar menu">
    <a class="<?php if ($_smarty_tpl->tpl_vars['REQUEST_URI']->value == '/') {?>active<?php }?> item" href="/">Personale</a>
    <a class="<?php if ($_smarty_tpl->tpl_vars['REQUEST_URI']->value == '/qualifiche') {?>active<?php }?> item" href="/qualifiche">Qualifiche</a>
    <a class="<?php if ($_smarty_tpl->tpl_vars['REQUEST_URI']->value == '/ssd') {?>active<?php }?> item" href="/ssd">SSD</a>
    <a class="<?php if ($_smarty_tpl->tpl_vars['REQUEST_URI']->value == '/incarichi') {?>active<?php }?> item" href="/incarichi">Incarichi</a>
    <a class="<?php if ($_smarty_tpl->tpl_vars['REQUEST_URI']->value == '/strutture') {?>active<?php }?> item" href="/strutture">Strutture</a>
    <a class="<?php if ($_smarty_tpl->tpl_vars['REQUEST_URI']->value == '/edifici') {?>active<?php }?> item" href="/edifici">Edifici</a>
    <a class="<?php if ($_smarty_tpl->tpl_vars['REQUEST_URI']->value == '/spazi') {?>active<?php }?> item" href="/spazi">Spazi</a>
</div>

<div id="bookcontainer" class="pusher">
    <header id="bookheader">
    </header>

    <div id="bookmenu_orizzontale">
        <div class="ui container">
            <div class="ui text menu">
                <div id="menu_item_first" onclick="window.location='/';"></div>
                 
                                <a class="item" href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
/">
                    <i class="big icon group"></i> Personale
                </a>
                <a class="item" href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
/qualifiche">
                    <i class="big icon certificate"></i> Qualifiche
                </a>
                <a class="item" href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
/ssd">
                    <i class="big icon bookmark"></i> SSD
                </a>
                <a class="item" href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
/incarichi">
                    <i class="big icon briefcase"></i> Incarichi
                </a>
                <a class="item" href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
/strutture">
                    <i class="big icon sitemap"></i> Strutture
                </a>
                <a class="item" href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
/edifici">
                    <i class="big icon building"></i> Edifici
                </a>
                <a class="item" href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
/spazi">
                    <i class="big icon map marker"></i> Spazi
                </a>
            </div>
        </div>
    </div>

    <div id="bookcontent">
        <div class="ui container">
            <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_6173956705bff1e5b8f2a67_26839724', "wmcontent", $this->tplIndex);
?>

        </div>
    </div>

    <div id="bookfooter">

        

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

<?php
}
}
/* {/block "html_body"} */
}
