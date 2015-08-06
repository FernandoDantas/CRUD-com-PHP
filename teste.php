<?php
require_once("classes/clientes.class.php");
$cliente = new clientes();
$cliente->setValor('nome','Ricardo');//setValor é uma função criada no arquivo base.class.php
$cliente->setValor('email','ricardo@site.com');
$cliente->setValor('telefone','33333333');
$cliente->setValor('mensagem','este é um teste do teste');

$cliente->inserir($cliente);

echo '<pre>';
print_r($cliente);
echo'</pre>';
?>