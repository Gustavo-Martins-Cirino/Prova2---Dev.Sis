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

    if ($titulo === '') {
        $erros[] = 'O título é obrigatório.';
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
    <div class="col-md-8 col-lg-6">
        <div class="card border-0 shadow-sm" style="border-radius: 1rem;">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                <h4 class="mb-0 fw-bold"><i class="bi bi-plus-circle text-primary me-2"></i>Nova Tarefa</h4>
            </div>
            <div class="card-body p-4">
                
                <?php if (!empty($erros)): ?>
                    <div class="alert alert-danger rounded-3 d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <ul class="mb-0 mb-0 ps-3">
                            <?php foreach ($erros as $erro): ?>
                                <li><?= htmlspecialchars($erro) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="post" action="nova.php">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3" id="titulo" name="titulo" placeholder="Título da tarefa" required autofocus value="<?= htmlspecialchars($_POST['titulo'] ?? '') ?>">
                        <label for="titulo">Título da tarefa <span class="text-danger">*</span></label>
                    </div>
                    
                    <div class="form-floating mb-4">
                        <textarea class="form-control rounded-3" id="descricao" name="descricao" placeholder="Detalhes" style="height: 120px"><?= htmlspecialchars($_POST['descricao'] ?? '') ?></textarea>
                        <label for="descricao">Detalhes (opcional)</label>
                    </div>
                    
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="index.php" class="btn btn-light rounded-pill px-4 fw-medium text-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold">
                            <i class="bi bi-save me-1"></i> Salvar
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

</div><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>