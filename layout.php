<?php
// layout.php — cabeçalho e navbar compartilhados entre todas as páginas
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Tarefas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', system-ui, sans-serif; }
        .navbar { background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); }
        .card { border-radius: 1rem; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark shadow-sm mb-5">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4" href="index.php">
            <i class="bi bi-check2-square me-2"></i>Tarefas
        </a>
        <div class="ms-auto d-flex align-items-center gap-3">
            <?php if (isset($_SESSION['usuario'])): ?>
                <span class="text-white opacity-75">
                    Olá, <strong class="text-white opacity-100"><?= htmlspecialchars($_SESSION['usuario']) ?></strong>
                </span>
                <a href="logout.php" class="btn btn-light btn-sm rounded-pill px-3 fw-medium">
                    <i class="bi bi-box-arrow-right me-1"></i> Sair
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="container pb-5">