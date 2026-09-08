<?php
require __DIR__.'/../src/layout.php';
$error='';
if($_SERVER['REQUEST_METHOD']==='POST') {
    guard();
    $r=query("SELECT * FROM clientes WHERE email=? AND situacao='Ativo'",'s',trim($_POST['login']??''))->get_result()->fetch_assoc();
    $pass=$_POST['senha']??'';
    if($r&&password_verify($pass,$r['senha'])) {
        session_regenerate_id(true);
        $_SESSION['logado']='sim';
        $_SESSION['nome']=$r['nome'];
        $_SESSION['cpf']=$r['cpf'];
        header('Location: carrinho.php');
        exit;
    }
    $error='E-mail ou senha incorretos. Confira os dados e tente novamente.';
}
Inicio('N');
?><section class="panel auth">
<p class="eyebrow">BEM-VINDO À DLSTORE</p><?php
if(isset($_SESSION['cpf'])):?><h1>Olá, <?= e($_SESSION['nome']) ?>.</h1>
<p class="muted">Você já está conectado.</p>
<a class="button wide" href="carrinho.php">Voltar ao carrinho</a>
<p class="auth-links">
<a href="sair.php">Sair da conta</a>
</p><?php
else:?><h1>Bom ter você de volta.</h1>
<p class="muted">Entre para continuar seu pedido.</p><?php
if($error):?><div class="error" role="alert"><?= e($error) ?></div><?php
endif;
?><form method="post"><?= token() ?><div class="field">
<label for="login">E-mail</label>
<input id="login" name="login" type="email" autocomplete="email" required value="<?= e($_POST['login']??'') ?>" placeholder="voce@exemplo.com">
</div>
<div class="field">
<label for="senha">Senha</label>
<input id="senha" name="senha" type="password" autocomplete="current-password" required>
</div>
<button class="button wide">Entrar →</button>
</form>
<p class="auth-links">Ainda não tem conta? <a href="cadastro.php">Criar minha conta</a>
</p><?php
endif;
?></section><?php
Fim();
?>
