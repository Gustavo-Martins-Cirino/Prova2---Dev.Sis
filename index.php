<?php
// index.php — listagem de tarefas do usuário logado
// Framework: Bootstrap 5 

session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

require 'conexao.php';

$stmt = $pdo->prepare("SELECT * FROM tarefas WHERE usuario_id = ? ORDER BY id DESC");
$stmt->execute([$_SESSION["usuario_id"]]);
$tarefas = $stmt->fetchAll();

include 'layout.php';
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Minhas Tarefas</h3>
    <a href="nova.php" class="btn btn-success">+ Nova Tarefa</a>
</div>

<?php if (empty($tarefas)): ?>
    <div class="alert alert-info">Nenhuma tarefa cadastrada ainda.</div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle bg-white shadow-sm">
            <thead class="table-primary">
                <tr>
                    <th>Título</th>
                    <th class="text-center">Status</th>
                    <th>Data de Criação</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tarefas as $tarefa): ?>
                <tr>
                    <td><?= htmlspecialchars($tarefa['titulo']) ?></td>
                    <td class="text-center">
                        <?php if ($tarefa['status'] === 'concluida'): ?>
                            <span class="badge bg-success">Concluída</span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark">Pendente</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($tarefa['criado_em']))) ?></td>
                    <td class="text-center">
                        <a href="editar.php?id=<?= (int)$tarefa['id'] ?>"
                           class="btn btn-sm btn-outline-primary">Editar</a>
                        
                        <?php if ($tarefa['status'] !== 'concluida'): ?>
                        <a href="concluir.php?id=<?= (int)$tarefa['id'] ?>"
                           class="btn btn-sm btn-outline-success">Concluir</a>
                        <?php endif; ?>
                        
                        <a href="excluir.php?id=<?= (int)$tarefa['id'] ?>"
                           class="btn btn-sm btn-outline-danger"
                           onclick="return confirm('Excluir esta tarefa?')">Excluir</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

</div><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>