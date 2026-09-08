<?php
require_once __DIR__.'/app.php';
function Inicio($exibeBanner='S') {
    ?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>DLStore | Tecnologia para o seu próximo nível</title>
<link rel="stylesheet" href="store.css?v=midnight2">
<script src="store.js?v=midnight2" defer>
</script>
</head>
<body>
<a class="skip" href="#conteudo">Pular para o conteúdo</a>
<div class="topline">PROJETO ACADÊMICO <span>Loja de demonstração • sem cobranças reais</span>
</div>
<header>
<div class="header-inner">
<a class="brand" href="index.php">DL<span>Store</span>
<i>®</i>
</a>
<form class="search" action="index.php" method="get" role="search">
<input aria-label="Buscar produtos" name="busca" placeholder="O que você está procurando?" value="<?= e($_GET['busca']??'') ?>">
<button aria-label="Pesquisar">⌕</button>
</form>
<nav class="account-nav" aria-label="Sua conta">
<a href="login.php"><?= isset($_SESSION['cpf'])?'Minha conta':'Entrar' ?></a>
<a class="cart-link" href="carrinho.php">Carrinho <b><?= count($_SESSION['Carrinho']??[]) ?></b>
</a>
</nav>
</div>
<nav class="category-nav" aria-label="Categorias">
<a href="index.php">Todos os produtos</a><?php
    $rs=query("SELECT * FROM categorias WHERE situacao='Ativo' ORDER BY nome")->get_result();
    while($r=$rs->fetch_assoc()):?><a href="categorias.php?id=<?= (int)$r['id_categoria'] ?>"><?= e($r['nome']) ?></a><?php
    endwhile;
    ?></nav>
</header>
<main id="conteudo"><?php
}
function Fim() {
    ?></main>
<footer>
<a class="brand" href="index.php">DL<span>Store</span>
</a>
<p>Tecnologia para o seu próximo nível.</p>
<small>Projeto acadêmico de loja virtual. Pedidos e pagamentos são demonstrativos.</small>
</footer>
</body>
</html><?php
}
