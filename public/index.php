<?php
require __DIR__.'/../src/layout.php';
$search=trim($_GET['busca']??$_POST['busca']??'');
Inicio();
?>
<?php
if(!$search):?><section class="hero">
<div>
<p class="eyebrow">SEU PRÓXIMO UPGRADE COMEÇA AQUI</p>
<h1>Mais desempenho.<br>
<em>Mais possibilidades.</em>
</h1>
<p>Encontre os equipamentos que combinam com o seu jeito de jogar, criar e trabalhar.</p>
<a class="button" href="#produtos">Explorar produtos ↗</a>
</div>
<img src="produtos/pc7.png" alt="Computador gamer">
</section><?php
endif;
?>
<section id="produtos">
<div class="section-title">
<div>
<p class="eyebrow">ESCOLHA SEU PRÓXIMO UPGRADE</p>
<h1><?= $search?'Resultados para “'.e($search).'”':'Destaques da loja' ?></h1>
</div>
</div>
<div class="product-grid"><?php
$rs=$search?query("SELECT * FROM produtos WHERE situacao='Ativo' AND (nome_produto LIKE ? OR detalhes LIKE ?) ORDER BY nome_produto",'ss','%'.$search.'%','%'.$search.'%')->get_result():query("SELECT * FROM produtos WHERE situacao='Ativo' AND destaque='S' ORDER BY nome_produto LIMIT 20")->get_result();
if(!$rs->num_rows)echo '<p>Nenhum produto encontrado. Tente outro termo.</p>';
while($r=$rs->fetch_assoc())card($r);
?></div>
</section><?php
Fim();
?>
