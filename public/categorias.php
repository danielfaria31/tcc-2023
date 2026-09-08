<?php
require __DIR__.'/../src/layout.php';
$id=(int)($_GET['id']??0);
$cat=query("SELECT nome FROM categorias WHERE id_categoria=?",'i',$id)->get_result()->fetch_assoc();
if(!$cat)http_response_code(404);
Inicio();
?><p class="breadcrumb">
<a href="index.php">Início</a> / Categorias</p>
<h1><?= e($cat['nome']??'Categoria não encontrada') ?></h1>
<div class="product-grid"><?php
$rs=query("SELECT * FROM produtos WHERE id_categoria=? AND situacao='Ativo'",'i',$id)->get_result();
while($r=$rs->fetch_assoc())card($r);
?></div><?php
Fim();
?>
