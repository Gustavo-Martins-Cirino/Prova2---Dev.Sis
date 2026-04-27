<?php
// layout.php — cabeçalho e navbar compartilhados entre todas as páginas
// Framework: Bootstrap 5 importado via CDN (https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css)
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Tarefas</title>
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">📋 Tarefas</a>
        <div class="ms-auto d-flex align-items-center gap-3">
            <?php if (isset($_SESSION['usuario'])): ?>
                <span class="text-white">
                    Olá, <strong><?= htmlspecialchars($_SESSION['usuario']) ?></strong>
                </span>
                <a href="logout.php" class="btn btn-outline-light btn-sm">Sair</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="container pb-5">