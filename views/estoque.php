<?php $inventory = $engine->getInventory(); ?>

<div class="max-w-5xl mx-auto">
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-800">Inventário de Ativos</h2>
        <p class="text-slate-500 text-sm">Gerencie equipamentos e níveis de alerta.</p>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden mb-10">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase">Equipamento (Clique para editar nome)</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase text-center">Quantidade</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase text-center">Mínimo</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase text-right">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php foreach($inventory as $item): ?>
                <tr class="hover:bg-slate-50/50 transition">
                    <form action="actions.php?method=updateFull" method="POST" onsubmit="return confirm('Confirmar alteração de dados?')">
                        <input type="hidden" name="id" value="<?= $item['id'] ?>">
                        <td class="px-6 py-4">
                            <input type="text" name="name" value="<?= $item['name'] ?>" 
                                class="bg-transparent border-b border-transparent focus:border-blue-500 focus:outline-none font-bold text-slate-700 w-full p-1">
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="actions.php?method=updateQty&id=<?= $item['id'] ?>&change=-1" class="w-8 h-8 flex items-center justify-center bg-slate-100 rounded-lg text-slate-600 hover:bg-red-100">-</a>
                                <span class="font-bold text-lg w-10 text-center"><?= $item['quantity'] ?></span>
                                <a href="actions.php?method=updateQty&id=<?= $item['id'] ?>&change=1" class="w-8 h-8 flex items-center justify-center bg-slate-100 rounded-lg text-slate-600 hover:bg-green-100">+</a>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <input type="number" name="min_stock" value="<?= $item['min_stock'] ?>" 
                                class="w-16 bg-slate-50 border border-slate-200 rounded p-1 text-center text-sm font-medium">
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <button type="submit" class="text-blue-600 hover:bg-blue-50 px-3 py-2 rounded-lg text-xs font-bold transition">SALVAR</button>
                            <a href="actions.php?method=deleteEquipment&id=<?= $item['id'] ?>" 
                               onclick="return confirm('Tem certeza que deseja excluir?')"
                               class="text-slate-300 hover:text-red-500 p-2 transition">✕</a>
                        </td>
                    </form>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="p-8 bg-slate-900 rounded-3xl shadow-xl">
        <h4 class="font-bold mb-6 text-white flex items-center gap-2">
            <span class="w-2 h-2 bg-blue-500 rounded-full"></span> Cadastrar Novo Ativo
        </h4>
        <form action="actions.php?method=saveEquipment" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-1">
                <label class="text-[10px] text-slate-400 uppercase font-bold ml-1">Nome do Equipamento</label>
                <input type="text" name="name" placeholder="Ex: Câmera Dome 4K" required 
                    class="w-full mt-1 p-3 bg-slate-800 border border-slate-700 rounded-xl text-white focus:border-blue-500 outline-none">
            </div>
            <div>
                <label class="text-[10px] text-slate-400 uppercase font-bold ml-1">Qtd Inicial</label>
                <input type="number" name="quantity" value="0" required 
                    class="w-full mt-1 p-3 bg-slate-800 border border-slate-700 rounded-xl text-white outline-none">
            </div>
            <div>
                <label class="text-[10px] text-slate-400 uppercase font-bold ml-1">Aviso de Estoque Mínimo</label>
                <input type="number" name="min_stock" value="5" required 
                    class="w-full mt-1 p-3 bg-slate-800 border border-slate-700 rounded-xl text-white outline-none">
            </div>
            <button class="md:col-span-3 bg-blue-600 text-white p-4 rounded-2xl font-bold hover:bg-blue-500 transition shadow-lg shadow-blue-900/20">
                Confirmar Cadastro
            </button>
        </form>
    </div>
</div>