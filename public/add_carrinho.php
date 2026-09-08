<?php
require __DIR__.'/../src/app.php';
guard();
$id=(int)($_POST['produto']??0);
$q=max(1,min(10,(int)($_POST['quantidade']??1)));
if(query("SELECT id_produto FROM produtos WHERE id_produto=? AND situacao='Ativo' AND valor > 0",'i',$id)->get_result()->num_rows) {
    for($i=0;$i<$q;$i++)$_SESSION['Carrinho'][]=$id;
    $_SESSION['Indice']=count($_SESSION['Carrinho']);
}
header('Location: carrinho.php');
exit;
