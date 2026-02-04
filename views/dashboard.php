<?php
$inventory = $engine->getInventory();
$orders = $engine->getOrders();

// Lógica de indicadores
$totalItems = count($inventory);
$totalOS = count($orders);
$criticos = array_filter($inventory, fn($i) => $i['quantity'] <= $i['min_stock']);
?>

<div class="animate-fadeIn">
    <header class="mb-10">
        <h2 class="text-3xl font-bold">Painel de Controle</h2>
        <p class="text-slate-500 text-sm">Resumo operacional da SecureOps</p>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Ativos no Inventário</p>
            <p class="text-4xl font-bold mt-2"><?= $totalItems ?></p>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Visitas Realizadas</p>
            <p class="text-4xl font-bold mt-2 text-blue-600"><?= $totalOS ?></p>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Itens em Alerta</p>
            <p class="text-4xl font-bold mt-2 <?= count($criticos) > 0 ? 'text-red-500' : 'text-emerald-500' ?>">
                <?= count($criticos) ?>
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        <div class="bg-white p-8 rounded-3xl border border-slate-200">
            <h3 class="font-bold text-lg mb-6 flex items-center gap-2">
                <span class="w-2 h-2 bg-red-500 rounded-full animate-ping"></span>
                Reposição Necessária
            </h3>
            <div class="space-y-4">
                <?php if (empty($criticos)): ?>
                    <p class="text-slate-400 text-sm italic">Estoque está saudável.</p>
                <?php endif; ?>
                <?php foreach ($criticos as $c): ?>
                    <div class="flex justify-between items-center p-4 bg-red-50 rounded-2xl">
                        <div>
                            <p class="font-bold text-slate-800"><?= $c['name'] ?></p>
                            <p class="text-xs text-red-600 uppercase font-bold">Restam apenas: <?= $c['quantity'] ?></p>
                        </div>
                        <a href="?page=estoque" class="text-xs bg-white px-3 py-2 rounded-lg shadow-sm font-bold border border-red-100 hover:bg-red-500 hover:text-white transition">Repor</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="bg-slate-900 text-white p-8 rounded-3xl">
            <h3 class="font-bold text-lg mb-6">Últimas Atividades</h3>
            <div class="space-y-6">
                <?php foreach (array_slice(array_reverse($orders), 0, 3) as $o): ?>
                    <div class="flex gap-4 items-start border-l-2 border-blue-500 pl-4">
                        <div>
                            <p class="text-sm font-bold"><?= $o['customer'] ?></p>
                            <p class="text-xs text-slate-400"><?= $o['date'] ?> - Visita técnica realizada</p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>