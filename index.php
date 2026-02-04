<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SecureOps - Gestão de Ativos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8fafc; }
        @media (min-width: 1024px) {
            .sidebar { position: fixed; top: 0; left: 0; bottom: 0; width: 18rem; }
            .main-content { margin-left: 18rem; }
        }
    </style>
</head>
<body class="flex flex-col lg:flex-row min-h-screen">
    <?php 
    require_once 'src/Engine.php';
    $engine = new \SecureOps\Engine();
    $page = $_GET['page'] ?? 'dashboard';
    ?>

    <nav class="sidebar bg-slate-900 text-slate-400 p-6 lg:p-8 flex flex-col gap-6 z-50">
        <div class="text-white font-black text-2xl flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-600 rounded-2xl flex items-center justify-center italic shadow-lg shadow-blue-500/20">S</div>
            <span class="tracking-tight">SecureOps</span>
        </div>
        
        <div class="flex lg:flex-col gap-2 overflow-x-auto lg:overflow-visible pb-2 lg:pb-0">
            <a href="?page=dashboard" class="flex-none lg:flex-1 p-3 lg:p-4 rounded-2xl transition font-semibold flex items-center gap-3 <?= $page=='dashboard'?'bg-blue-600 text-white shadow-lg':'hover:bg-slate-800' ?>">
                <span>📊</span> <span class="hidden lg:inline">Dashboard</span>
            </a>
            <a href="?page=estoque" class="flex-none lg:flex-1 p-3 lg:p-4 rounded-2xl transition font-semibold flex items-center gap-3 <?= $page=='estoque'?'bg-blue-600 text-white shadow-lg':'hover:bg-slate-800' ?>">
                <span>📦</span> <span class="hidden lg:inline">Inventário</span>
            </a>
            <a href="?page=os" class="flex-none lg:flex-1 p-3 lg:p-4 rounded-2xl transition font-semibold flex items-center gap-3 <?= $page=='os'?'bg-blue-600 text-white shadow-lg':'hover:bg-slate-800' ?>">
                <span>📄</span> <span class="hidden lg:inline">Ordens de Visita</span>
            </a>
        </div>
    </nav>

    <main class="main-content flex-1 p-4 lg:p-10 w-full overflow-x-hidden">
        <div class="max-w-7xl mx-auto">
            <?php include "views/{$page}.php"; ?>
        </div>
    </main>
</body>
</html>