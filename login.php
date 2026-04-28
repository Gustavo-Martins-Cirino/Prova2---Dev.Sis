<!-- Bootstrap 5 CSS -->
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background: #f4f7f6; }
    </style>
</head>
<body class="d-flex align-items-center" style="min-height:100vh;">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="text-center mb-4">
                <i class="bi bi-check2-square text-primary" style="font-size: 3rem;"></i>
                <h3 class="fw-bold mt-2">Bem-vindo de volta</h3>
                <p class="text-muted">Acesse seu gerenciador de tarefas</p>
            </div>

            <div class="card border-0 shadow-lg" style="border-radius: 1rem;">
                <div class="card-body p-4 p-md-5">
                    <?php if ($erro): ?>
                        <div class="alert alert-danger d-flex align-items-center rounded-3" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <div><?= htmlspecialchars($erro) ?></div>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="login.php">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" id="usuario" name="usuario" placeholder="Usuário" required autofocus value="<?= htmlspecialchars($_POST['usuario'] ?? '') ?>">
                            <label for="usuario"><i class="bi bi-person me-2"></i>Usuário</label>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control rounded-3" id="senha" name="senha" placeholder="Senha" required>
                            <label for="senha"><i class="bi bi-lock me-2"></i>Senha</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold fs-5 shadow-sm">
                            Entrar <i class="bi bi-arrow-right-short"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>