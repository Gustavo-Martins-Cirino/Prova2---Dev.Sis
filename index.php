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

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0 fw-bold text-dark"><i class="bi bi-journal-text me-2 text-primary"></i>Minhas Tarefas</h3>
    <a href="nova.php" class="btn btn-primary rounded-pill px-4 shadow-sm fw-medium">
        <i class="bi bi-plus-lg me-1"></i> Nova Tarefa
    </a>
</div>

<?php if (empty($tarefas)): ?>
    <div class="card border-0 shadow-sm text-center py-5">
        <div class="card-body">
            <i class="bi bi-inbox text-muted opacity-50" style="font-size: 4rem;"></i>
            <h5 class="mt-3 text-muted">Tudo limpo por aqui!</h5>
            <p class="text-muted mb-4">Você ainda não tem tarefas cadastradas.</p>
            <a href="nova.php" class="btn btn-outline-primary rounded-pill px-4">Criar primeira tarefa</a>
        </div>
    </div>
<?php else: ?>
    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary">
                    <tr>
                        <th class="ps-4 border-0">Título</th>
                        <th class="text-center border-0">Status</th>
                        <th class="border-0">Data de Criação</th>
                        <th class="text-center border-0 pe-4">Ações</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    <?php foreach ($tarefas as $tarefa): ?>
                    <tr>
                        <td class="ps-4 fw-medium text-dark"><?= htmlspecialchars($tarefa['titulo']) ?></td>
                        <td class="text-center">
                            <?php if ($tarefa['status'] === 'concluida'): ?>
                                <span class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill px-3 py-2"><i class="bi bi-check-circle me-1"></i>Concluída</span>
                            <?php else: ?>
                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning rounded-pill px-3 py-2"><i class="bi bi-clock-history me-1"></i>Pendente</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-muted">
                            <i class="bi bi-calendar3 me-1"></i> <?= htmlspecialchars(date('d/m/Y', strtotime($tarefa['criado_em']))) ?>
                            <small class="ms-1"><?= htmlspecialchars(date('H:i', strtotime($tarefa['criado_em']))) ?></small>
                        </td>
                        <td class="text-center pe-4">
    <div class="btn-group shadow-sm rounded-pill" role="group">
        
        <?php if ($tarefa['status'] !== 'concluida'): ?>
        <a href="concluir.php?id=<?= $tarefa['id'] ?>" class="btn btn-sm btn-light text-success border" title="Concluir">
            <i class="bi bi-check-lg"></i>
        </a>
        <?php endif; ?>
        
        <a href="editar.php?id=<?= $tarefa['id'] ?>" class="btn btn-sm btn-light text-primary border" title="Editar">
            <i class="bi bi-pencil-square"></i>
        </a>
        
        <a href="excluir.php?id=<?= $tarefa['id'] ?>" class="btn btn-sm btn-light text-danger border" onclick="return confirm('Tem certeza que deseja excluir esta tarefa?')" title="Excluir">
            <i class="bi bi-trash3"></i>
        </a>
        
    </div>
</td>
                        
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

</div><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>