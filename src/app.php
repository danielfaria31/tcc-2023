<?php
if (session_status() !== PHP_SESSION_ACTIVE)  {
    session_name('dlstore_portfolio');
    ini_set('session.use_strict_mode', '1');
    session_set_cookie_params([ 'httponly' => true, 'samesite' => 'Lax', 'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off', ]);
    session_start();
}
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: same-origin');
header('X-Frame-Options: DENY');
require_once __DIR__.'/conexao.php';
function e($v) {
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}
function money($v) {
    return 'R$ '.number_format((float)$v,2,',','.');
}
function query($sql,$types='',...$args) {
    global $conexao;
    $s=$conexao->prepare($sql);
    if($types) $s->bind_param($types,...$args);
    $s->execute();
    return $s;
}
function token() {
    if(empty($_SESSION['csrf']))$_SESSION['csrf']=bin2hex(random_bytes(24));
    return '<input type="hidden" name="csrf" value="'.e($_SESSION['csrf']).'">';
}
function guard() {
    if($_SERVER['REQUEST_METHOD']!=='POST'||!hash_equals($_SESSION['csrf']??'',$_POST['csrf']??'!')) {
        http_response_code(403);
        exit('Solicitação inválida. Volte e atualize a página.');
    }
}
function cart() {
    $items=[];
    foreach(array_count_values(array_map('intval',$_SESSION['Carrinho']??[])) as $id=>$q) {
        $r=query("SELECT * FROM produtos WHERE id_produto=? AND situacao='Ativo' AND valor > 0",'i',$id)->get_result()->fetch_assoc();
        if($r) {
            $r['qtd']=$q;
            $items[]=$r;
        }
    }
    return $items;
}
function card($r) {
    ?><article class="product-card">
<a class="product-image" href="detalhes.php?ID=<?= (int)$r['id_produto'] ?>">
<img loading="lazy" src="produtos/<?= e($r['foto_principal']) ?>" alt="<?= e($r['nome_produto']) ?>">
</a>
<div class="card-body">
<p class="eyebrow">DLSTORE • SELEÇÃO GAMER</p>
<h3>
<a href="detalhes.php?ID=<?= (int)$r['id_produto'] ?>"><?= e($r['nome_produto']) ?></a>
</h3><?php
    if((float)$r['valor'] > 0): ?><p class="price"><?= money($r['valor']) ?></p>
<p class="muted">em até 12x de <?= money($r['valor']/12) ?></p><?php
    else: ?><p class="price">Indisponível</p>
<p class="muted">Preço não cadastrado</p><?php
    endif;
    ?><a class="button secondary" href="detalhes.php?ID=<?= (int)$r['id_produto'] ?>">Ver produto <span>↗</span>
</a>
</div>
</article><?php
}
