<?php
// login.php — autenticação com MD5 e sessão
// Framework: Bootstrap 5

session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax']);
session_start();


if (isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

require 'conexao.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $senha   = md5($_POST['senha'] ?? '');

    $stmt = $pdo->prepare('SELECT id, usuario FROM usuarios WHERE usuario = ? AND senha = ?');
    $stmt->execute([$usuario, $senha]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['usuario']    = $user['usuario'];
        header('Location: index.php');
        exit;
    } else {
        $erro = 'Usuário ou senha inválidos. Tente novamente.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Gerenciador de Tarefas</title>
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light d-flex align-items-center" style="min-height:100vh;">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">📋 Gerenciador de Tarefas</h4>
                </div>
                <div class="card-body p-4">
                    <h5 class="card-title text-center mb-4">Entrar</h5>

                    <?php if ($erro): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= htmlspecialchars($erro) ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="login.php">
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuário</label>
                            <input type="text" class="form-control" id="usuario"
                                   name="usuario" required autofocus
                                   value="<?= htmlspecialchars($_POST['usuario'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="senha"
                                   name="senha" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Entrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>