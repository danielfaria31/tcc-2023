<?php
require __DIR__.'/../src/layout.php';
guard();
if(empty($_SESSION['cpf'])) {
    header('Location: login.php');
    exit;
}
$items=cart();
$data=[];
foreach(['cep','endereco','numero','complemento','bairro','cidade','uf'] as $key)$data[$key]=trim($_POST[$key]??'');
$_SESSION['checkout_old']=$data;
$valid=count($items)>0;
foreach(['endereco','numero','bairro','cidade'] as $key)if(!$data[$key]||strlen($data[$key])>100)$valid=false;
$cep=preg_replace('/\D/','',$data['cep']);
$ufs=explode(' ','AC AL AP AM BA CE DF ES GO MA MT MS MG PA PB PR PE PI RJ RN RS RO RR SC SP SE TO');
$pay=$_POST['forma_pagto']??'';
$parc=$pay==='Cartão'?(int)($_POST['parcelas']??1):1;
if(strlen($cep)!==8||!in_array($data['uf'],$ufs)||!in_array($pay,['Boleto','Cartão'])||$parc<1||$parc>12||strlen($data['complemento'])>80)$valid=false;
if(!$valid) {
    $_SESSION['checkout_error']='Confira o endereço, o CEP e a forma de pagamento. Seu pedido ainda não foi enviado.';
    header('Location: carrinho.php');
    exit;
}
$total=array_sum(array_map(fn($r)=>$r['valor']*$r['qtd'],$items));
$endereco=$data['endereco'].', '.$data['numero'].($data['complemento']?' - '.$data['complemento']:'');
$conexao->begin_transaction();
try {
    query("INSERT INTO vendas (data_venda,cpf,forma_pagto,parcelas,endereco,cidade,bairro,cep,uf,valor_total,valor_frete,prazo_entrega) VALUES (NOW(),?,?,?,?,?,?,?,?,?,0,'Demonstração')",'ssisssssd',$_SESSION['cpf'],$pay,$parc,$endereco,$data['cidade'],$data['bairro'],$cep,$data['uf'],$total);
    $id=$conexao->insert_id;
    foreach($items as $r)query('INSERT INTO item_vendas (id_venda,id_produto,quantidade,valor) VALUES (?,?,?,?)','iiid',$id,$r['id_produto'],$r['qtd'],$r['valor']);
    $conexao->commit();
    $_SESSION['last_order']=['id'=>$id,'total'=>$total];
    unset($_SESSION['Carrinho'],$_SESSION['Indice'],$_SESSION['checkout_old']);
    header('Location: pedido.php');
    exit;
}
catch(Throwable $ex) {
    $conexao->rollback();
    $_SESSION['checkout_error']='Não foi possível registrar o pedido. Seus produtos continuam no carrinho.';
    header('Location: carrinho.php');
    exit;
}
