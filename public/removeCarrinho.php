<?php
require __DIR__.'/../src/app.php';
guard();
$id=(int)($_POST['id']??0);
$_SESSION['Carrinho']=array_values(array_filter($_SESSION['Carrinho']??[],fn($v)=>(int)$v!==$id));
$_SESSION['Indice']=count($_SESSION['Carrinho']);
header('Location: carrinho.php');
exit;
