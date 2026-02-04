<!DOCTYPE html>
<html lang="pt-br" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SecureOps | Tech Control</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&family=Plus+Jakarta+Sans:wght@400;600;800&display=swap');
        
        /* Trava o scroll global para permitir scrolls internos */
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #F8FAFC; 
            height: 100vh; 
            overflow: hidden; 
        }

        .mono { font-family: 'JetBrains Mono', monospace; }
        .bento-card { background: white; border: 1px solid #E2E8F0; border-radius: 12px; }
        
        /* Scrollbar estilizada */
        .custom-scroll::-webkit-scrollbar { width: 5px; }
        .custom-scroll::-webkit-scrollbar-track { background: transparent; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 10px; }

        @media (min-width: 1024px) {
            .sidebar-fixed { position: fixed; top: 0; left: 0; bottom: 0; width: 80px; }
            .main-container { margin-left: 80px; height: 100vh; }
        }
    </style>
</head>
<body class="antialiased text-slate-900">
    <?php 
    require_once 'src/Engine.php';
    $engine = new \SecureOps\Engine();
    $page = $_GET['page'] ?? 'dashboard';
    ?>

    <div class="flex flex-col lg:flex-row h-full">
        <aside class="sidebar-fixed w-full lg:w-20 bg-[#0F172A] flex lg:flex-col items-center py-4 lg:py-8 px-4 lg:px-0 gap-8 z-50 shadow-xl shrink-0">
            <div class="bg-blue-600 p-3 rounded-xl text-white font-bold text-xl shadow-lg shadow-blue-500/20">SO</div>
            <nav class="flex flex-row lg:flex-col flex-1 gap-6">
                <a href="?page=dashboard" class="p-3 rounded-xl transition <?= $page=='dashboard'?'bg-slate-800 text-blue-400':'text-slate-500 hover:text-white' ?>">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                </a>
                <a href="?page=estoque" class="p-3 rounded-xl transition <?= $page=='estoque'?'bg-slate-800 text-blue-400':'text-slate-500 hover:text-white' ?>">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 11m8 4V4"/></svg>
                </a>
                <a href="?page=os" class="p-3 rounded-xl transition <?= $page=='os'?'bg-slate-800 text-blue-400':'text-slate-500 hover:text-white' ?>">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </a>
            </nav>
        </aside>

        <main class="main-container flex-1 w-full overflow-hidden">
            <?php if($page === 'os'): ?>
                <?php include "views/os.php"; ?>
            <?php else: ?>
                <div class="h-full overflow-y-auto custom-scroll p-4 lg:p-10">
                    <div class="max-w-7xl mx-auto">
                        <?php include "views/{$page}.php"; ?>
                    </div>
                </div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>