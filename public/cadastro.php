<?php
require __DIR__.'/../src/layout.php';
$error='';
if($_SERVER['REQUEST_METHOD']==='POST') {
    guard();
    $cpf=preg_replace('/\D/','',$_POST['cpf']??'');
    $nome=trim($_POST['nome']??'');
    $email=trim($_POST['email']??'');
    $senha=$_POST['senha']??'';
    if(strlen($cpf)!==11||strlen($nome)<3||strlen($nome)>100||!filter_var($email,FILTER_VALIDATE_EMAIL)||strlen($email)>100||strlen($senha)<8) {
        $error='Confira os dados: CPF com 11 dígitos, nome, e-mail válido e senha com pelo menos 8 caracteres.';
    }
    elseif($senha!==($_POST['confirmar']??'')) {
        $error='As senhas não coincidem.';
    }
    elseif(query('SELECT cpf FROM clientes WHERE cpf=? OR email=?','ss',$cpf,$email)->get_result()->num_rows) {
        $error='Já existe uma conta com este CPF ou e-mail.';
    }
    else {
        query('INSERT INTO clientes (cpf,nome,email,senha,data_cadastro) VALUES (?,?,?,?,NOW())','ssss',$cpf,$nome,$email,password_hash($senha,PASSWORD_DEFAULT));
        session_regenerate_id(true);
        $_SESSION['cpf']=$cpf;
        $_SESSION['nome']=$nome;
        $_SESSION['logado']='sim';
        header('Location: carrinho.php');
        exit;
    }
}
Inicio('N');
?><section class="panel auth">
<p class="eyebrow">SUA CONTA DLSTORE</p>
<h1>Vamos começar?</h1>
<p class="muted">Crie uma conta para testar a experiência de compra.</p><?php
if($error):?><div class="error" role="alert"><?= e($error) ?></div><?php
endif;
?><form method="post"><?= token() ?><?php
foreach([['nome','Nome completo','text','name'],['cpf','CPF (11 dígitos)','text','off'],['email','E-mail','email','email'],['senha','Senha (mínimo de 8 caracteres)','password','new-password'],['confirmar','Confirmar senha','password','new-password']] as [$n,$label,$type,$auto]):?><div class="field">
<label for="<?= $n ?>"><?= $label ?></label>
<input id="<?= $n ?>" name="<?= $n ?>" type="<?= $type ?>" autocomplete="<?= $auto ?>" required <?= $type==='password'?'minlength="8"':($n==='cpf'?'maxlength="14" inputmode="numeric"':'maxlength="100"') ?> value="<?= $type==='password'?'':e($_POST[$n]??'') ?>">
</div><?php
endforeach;
?><button class="button wide">Criar conta →</button>
</form>
<p class="auth-links">Já tem uma conta? <a href="login.php">Entrar</a>
</p>
</section><?php
Fim();
?>
