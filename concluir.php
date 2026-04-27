<?php
// concluir.php — marca a tarefa como "concluida"

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

require 'conexao.php';

$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare(
    "UPDATE tarefas SET status = 'concluida' WHERE id = ? AND usuario_id = ?"
);
$stmt->execute([$id, $_SESSION['usuario_id']]);

header('Location: index.php');
exit;
