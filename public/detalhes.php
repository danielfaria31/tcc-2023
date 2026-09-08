<?php
require __DIR__.'/../src/layout.php';
$id=(int)($_GET['ID']??0);
$r=query("SELECT p.*, c.nome AS categoria FROM produtos p LEFT JOIN categorias c ON c.id_categoria=p.id_categoria WHERE id_produto=? AND p.situacao='Ativo'",'i',$id)->get_result()->fetch_assoc();
if(!$r)http_response_code(404);
Inicio();
if(!$r) {
    echo '<section class="panel empty"><h1>Produto não encontrado</h1><a class="button" href="index.php">Explorar a loja</a></section>';
    Fim();
    exit;
}
?>
<nav class="breadcrumb" aria-label="Caminho">
<a href="index.php">Início</a>
<span>/</span>
<a href="categorias.php?id=<?= (int)$r['id_categoria'] ?>"><?= e($r['categoria']) ?></a>
<span>/</span>Produto</nav>
<section class="product-detail">
<div class="gallery">
<span class="tag">SELEÇÃO DLSTORE</span>
<button class="image-zoom" type="button" aria-label="Ampliar foto do produto" data-zoom>
<img src="produtos/<?= e($r['foto_principal']) ?>" alt="<?= e($r['nome_produto']) ?>">
</button>
<span class="zoom-hint">Clique na foto para ampliar ↗</span>
<small>Imagem ilustrativa do produto</small>
</div>
<div class="product-info">
<p class="eyebrow"><?= e($r['categoria']) ?> · CÓD. <?= $id ?></p>
<h1><?= e($r['nome_produto']) ?></h1>
<p class="description"><?= e($r['detalhes']) ?></p><?php
if((float)$r['valor']>0): ?><div class="price-block">
<span class="muted">Preço do produto</span>
<p class="big-price"><?= money($r['valor']) ?></p>
<p>ou até <strong>12x de <?= money($r['valor']/12) ?></strong> sem juros</p>
</div>
<form action="add_carrinho.php" method="post"><?= token() ?><input type="hidden" name="produto" value="<?= $id ?>">
<label for="quantidade">Quantidade</label>
<div class="buy-row">
<input id="quantidade" type="number" name="quantidade" value="1" min="1" max="10" required>
<button class="button">Adicionar ao carrinho <span>→</span>
</button>
</div>
</form><?php
else: ?><div class="notice">Produto indisponível: preço ainda não cadastrado.</div><?php
endif;
?><div class="product-notes">
<p>
<strong>Detalhes antes de comprar</strong>
<br>Confira a descrição e as especificações do produto.</p>
<p>
<strong>Compra demonstrativa</strong>
<br>Nenhum pagamento real será processado.</p>
</div>
</div>
</section>
<section class="panel specifications">
<p class="eyebrow">CONHEÇA O PRODUTO</p>
<h2>Descrição e informações</h2>
<p><?= nl2br(e($r['detalhes'])) ?></p>
</section>
<dialog class="image-dialog" id="product-zoom" aria-label="Foto ampliada do produto">
<button type="button" data-close-zoom>Fechar ×</button>
<img src="produtos/<?= e($r['foto_principal']) ?>" alt="<?= e($r['nome_produto']) ?>">
<p><?= e($r['nome_produto']) ?></p>
</dialog><?php
Fim();
?>
