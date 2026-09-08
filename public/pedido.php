<?php
require __DIR__.'/../src/layout.php';
Inicio('N');
$r=$_SESSION['last_order']??null;
?><section class="panel empty">
<p class="eyebrow">DLSTORE</p>
<h1><?= $r?'Pedido de teste confirmado!':'Nenhum pedido para exibir' ?></h1><?php
if($r):?><p>Pedido #<?= (int)$r['id'] ?> · Total <?= money($r['total']) ?></p>
<p class="muted">Tudo certo com a sua simulação. Nenhuma cobrança ou entrega será realizada.</p><?php
endif;
?><a class="button" href="index.php">Voltar à loja →</a>
</section><?php
Fim();
?>
