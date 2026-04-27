<?php
// nova.php — cadastro de nova tarefa com prepared statement

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

require 'conexao.php';

$erros = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo    = trim($_POST['titulo']    ?? '');
    $descricao = trim($_POST['descricao'] ?? '');

    if ($titulo) {
        $stmt = $pdo->prepare("INSERT INTO tarefas (titulo, descricao, usuario_id) VALUES (?, ?, ?)");
        $stmt->execute([$titulo, $descricao, $_SESSION["usuario_id"]]);
        header("Location: index.php");
        exit;
    }

    if (empty($erros)) {
        $stmt = $pdo->prepare('INSERT INTO tarefas (titulo, descricao, usuario_id) VALUES (?, ?, ?)');
        $stmt->execute([$titulo, $descricao, $_SESSION['usuario_id']]);
        header('Location: index.php');
        exit;
    }
}

include 'layout.php';
?>

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Nova Tarefa</h5>
            </div>
            <div class="card-body p-4">

                <?php if (!empty($erros)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($erros as $erro): ?>
                                <li><?= htmlspecialchars($erro) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="post" action="nova.php">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="titulo" name="titulo"
                               required value="<?= htmlspecialchars($_POST['titulo'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao"
                                  rows="4"><?= htmlspecialchars($_POST['descricao'] ?? '') ?></textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">Salvar</button>
                        <a href="index.php" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

</div><!-- /container (aberto em layout.php) -->
<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>