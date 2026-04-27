<?php
// editar.php — edição de tarefa (título, descrição e status)

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

require 'conexao.php';

$id = (int)($_GET['id'] ?? 0);

// busca a tarefa garantindo que pertence ao usuário logado
$stmt = $pdo->prepare('SELECT id, titulo, descricao, status FROM tarefas WHERE id = ? AND usuario_id = ?');
$stmt->execute([$id, $_SESSION['usuario_id']]);
$tarefa = $stmt->fetch();

if (!$tarefa) {
    header('Location: index.php');
    exit;
}

$erros = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo    = trim($_POST['titulo']    ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $status    = $_POST['status'] ?? 'pendente';

    if ($titulo === '') {
        $erros[] = 'O título é obrigatório.';
    }

    if (!in_array($status, ['pendente', 'concluida'])) {
        $erros[] = 'Status inválido.';
    }

    if (empty($erros)) {
        $stmt = $pdo->prepare(
            'UPDATE tarefas SET titulo = ?, descricao = ?, status = ? WHERE id = ? AND usuario_id = ?'
        );
        $stmt->execute([$titulo, $descricao, $status, $id, $_SESSION['usuario_id']]);
        header('Location: index.php');
        exit;
    }

    $tarefa['titulo']    = $titulo;
    $tarefa['descricao'] = $descricao;
    $tarefa['status']    = $status;
}

include 'layout.php';
?>

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Editar Tarefa</h5>
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

                <form method="post" action="editar.php?id=<?= $id ?>">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="titulo" name="titulo"
                               required value="<?= htmlspecialchars($tarefa['titulo']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao"
                                  rows="4"><?= htmlspecialchars($tarefa['descricao']) ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="pendente"  <?= $tarefa['status'] === 'pendente'  ? 'selected' : '' ?>>Pendente</option>
                            <option value="concluida" <?= $tarefa['status'] === 'concluida' ? 'selected' : '' ?>>Concluída</option>
                        </select>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <a href="index.php" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
