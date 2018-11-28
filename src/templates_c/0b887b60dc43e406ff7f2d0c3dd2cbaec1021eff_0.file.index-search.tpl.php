<?php
/* Smarty version 3.1.33, created on 2018-11-29 00:01:47
  from '/var/www/unibook/src/templates/index-search.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5bff1e5b8db4e7_62792579',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0b887b60dc43e406ff7f2d0c3dd2cbaec1021eff' => 
    array (
      0 => '/var/www/unibook/src/templates/index-search.tpl',
      1 => 1543401545,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5bff1e5b8db4e7_62792579 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_19559136265bff1e5b8d9688_57064113', "wmcontent");
$_smarty_tpl->inheritance->endChild($_smarty_tpl, "template-base.tpl");
}
/* {block "wmcontent"} */
class Block_19559136265bff1e5b8d9688_57064113 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'wmcontent' => 
  array (
    0 => 'Block_19559136265bff1e5b8d9688_57064113',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


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

<?php
}
}
/* {/block "wmcontent"} */
}
