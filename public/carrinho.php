<?php
require __DIR__.'/../src/layout.php';
$items=cart();
$total=array_sum(array_map(fn($r)=>$r['valor']*$r['qtd'],$items));
$old=$_SESSION['checkout_old']??[];
function field($name,$label,$auto='',$full=false) {
    global $old;
    ?><div class="field <?= $full?'full':'' ?>">
<label for="<?= $name ?>"><?= $label ?></label>
<input id="<?= $name ?>" name="<?= $name ?>" autocomplete="<?= $auto ?>" value="<?= e($old[$name]??'') ?>" required maxlength="<?= $name==='cep'?9:100 ?>" <?= $name==='cep'?'inputmode="numeric" pattern="[0-9]{5}-?[0-9]{3}" placeholder="00000-000"':'' ?>>
</div><?php
}
Inicio('N');
?><p class="breadcrumb">
<a href="index.php">Início</a> / Carrinho</p>
<h1>Seu próximo upgrade está aqui.</h1>
<p class="muted">Confira os produtos e preencha os dados de entrega.</p>
<div class="steps">
<strong>01 · Carrinho</strong>
<span>02 · Dados de entrega</span>
<span>03 · Confirmação</span>
</div><?php
if(!$items):?><section class="panel empty">
<h2>Seu carrinho está vazio</h2>
<p class="muted">Explore a loja e escolha seu próximo equipamento.</p>
<a class="button" href="index.php">Encontrar produtos →</a>
</section><?php
else:?>
<?php
if(isset($_SESSION['checkout_error'])):?><div class="error" role="alert"><?= e($_SESSION['checkout_error']) ?></div><?php
unset($_SESSION['checkout_error']);
endif;
?>
<div class="checkout-grid">
<form id="checkout" action="confirma_venda.php" method="post"><?= token() ?><section class="panel">
<div class="step-title">
<b>1</b>
<h2>Sua conta</h2>
</div><?php
if(isset($_SESSION['cpf'])):?><p>Olá, <strong><?= e($_SESSION['nome']) ?></strong>. Vamos preparar seu pedido demonstrativo.</p><?php
else:?><p class="muted">Entre na sua conta para concluir o pedido.</p>
<a class="button secondary" href="login.php">Entrar ou criar conta →</a><?php
endif;
?></section>
<section class="panel">
<div class="step-title">
<b>2</b>
<h2>Endereço de entrega</h2>
</div>
<p class="muted">Todos os campos abaixo são obrigatórios, exceto complemento.</p>
<div class="fields"><?php
field('cep','CEP','postal-code');
?><div class="field">
<label for="uf">Estado</label>
<select id="uf" name="uf" autocomplete="address-level1" required>
<option value="">Selecione</option><?php
foreach(explode(' ','AC AL AP AM BA CE DF ES GO MA MT MS MG PA PB PR PE PI RJ RN RS RO RR SC SP SE TO') as $uf):?><option <?= ($old['uf']??'')===$uf?'selected':'' ?>><?= $uf ?></option><?php
endforeach;
?></select>
</div><?php
field('endereco','Rua ou avenida','address-line1',true);
field('numero','Número');
?><div class="field">
<label for="complemento">Complemento <span class="muted">(opcional)</span>
</label>
<input id="complemento" name="complemento" autocomplete="address-line2" maxlength="80" placeholder="Apartamento, bloco…" value="<?= e($old['complemento']??'') ?>">
</div><?php
field('bairro','Bairro');
field('cidade','Cidade','address-level2');
?></div>
<div class="notice">Entrega demonstrativa: frete de R$ 0,00 para testar o pedido. Não há cotação nem envio real.</div>
</section>
<section class="panel">
<div class="step-title">
<b>3</b>
<h2>Forma de pagamento</h2>
</div>
<fieldset>
<legend class="muted">Escolha como deseja simular o pagamento</legend>
<label class="payment-option">
<input type="radio" name="forma_pagto" value="Boleto" checked>Boleto à vista</label>
<label class="payment-option">
<input type="radio" name="forma_pagto" value="Cartão">Cartão parcelado</label>
</fieldset>
<div id="installments" hidden>
<label for="parcelas">Número de parcelas</label>
<select id="parcelas" name="parcelas"><?php
for($i=1;$i<=12;$i++):?><option value="<?= $i ?>"><?= $i ?>x de <?= money($total/$i) ?> sem juros</option><?php
endfor;
?></select>
</div>
<p class="notice">Esta loja é um projeto acadêmico. Não solicitamos número de cartão, validade ou código de segurança. Nenhuma cobrança será feita.</p>
</section>
</form>
<aside class="panel summary">
<h2>Resumo do pedido</h2>
<p class="muted"><?= array_sum(array_column($items,'qtd')) ?> item(ns) no carrinho</p><?php
foreach($items as $r):?><article class="cart-item">
<img src="produtos/<?= e($r['foto_principal']) ?>" alt="<?= e($r['nome_produto']) ?>">
<div>
<h3>
<a href="detalhes.php?ID=<?= $r['id_produto'] ?>"><?= e($r['nome_produto']) ?></a>
</h3>
<p><?= $r['qtd'] ?> un. × <?= money($r['valor']) ?></p>
<form action="removeCarrinho.php" method="post"><?= token() ?><input type="hidden" name="id" value="<?= $r['id_produto'] ?>">
<button class="remove" aria-label="Remover <?= e($r['nome_produto']) ?>">Remover</button>
</form>
</div>
</article><?php
endforeach;
?><div class="totals">
<span>Subtotal</span>
<span><?= money($total) ?></span>
</div>
<div class="totals">
<span>Frete demonstrativo</span>
<span>R$ 0,00</span>
</div>
<div class="totals final">
<span>Total</span>
<span><?= money($total) ?></span>
</div><?php
if(isset($_SESSION['cpf'])):?><button class="button wide" type="submit" form="checkout">Confirmar pedido de teste →</button><?php
else:?><a class="button wide" href="login.php">Entrar para continuar →</a><?php
endif;
?><p class="auth-links">
<a href="index.php">Continuar comprando</a>
</p>
</aside>
</div><?php
endif;
Fim();
?>
