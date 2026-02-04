<?php
$inventory = $engine->getInventory();
$orders = $engine->getOrders();
?>

<div class="flex flex-col lg:flex-row gap-8 lg:h-[calc(100vh-120px)]">

    <div class="w-full lg:w-1/3 lg:overflow-y-auto lg:pr-2">
        <form id="os-form" action="actions.php?method=createOS" method="POST" class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
            <h3 id="form-title" class="font-bold text-xl mb-6 text-slate-800">Nova Visita</h3>
            <div class="space-y-4">
                <input type="hidden" name="os_id" id="os_id">
                <input type="text" name="customer" id="customer" placeholder="Cliente" required class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:ring-2 ring-blue-500/20">
                <input type="text" name="address" id="address" placeholder="Endereço" required class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl">

                <div class="p-4 bg-blue-50/50 rounded-2xl border border-blue-100">
                    <p class="text-[10px] font-bold text-blue-400 uppercase mb-3 tracking-widest">Itens da Ordem</p>
                    <div id="items-container" class="space-y-2 mb-4"></div>
                    <select id="add-item-trigger" class="w-full p-3 bg-white border border-blue-200 rounded-xl text-xs font-bold text-blue-600 outline-none">
                        <option value="">+ ADICIONAR ITEM</option>
                        <?php foreach ($inventory as $item): if ($item['quantity'] <= 0) continue; ?>
                            <option value="<?= $item['id'] ?>" data-name="<?= $item['name'] ?>" data-max="<?= $item['quantity'] ?>">
                                <?= $item['name'] ?> (<?= $item['quantity'] ?> disp.)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <textarea name="reason" id="reason" placeholder="Relatório da Visita" rows="3" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl text-sm"></textarea>
                <button type="submit" class="w-full bg-blue-600 text-white p-4 rounded-2xl font-bold shadow-lg shadow-blue-200 hover:bg-blue-700 transition">Salvar Ordem</button>
            </div>
        </form>
    </div>

    <div class="w-full lg:w-2/3 lg:overflow-y-auto lg:pl-2 pb-20">
        <h3 class="font-bold text-slate-400 uppercase text-[10px] mb-4 tracking-widest">Histórico de Visitas</h3>
        <div class="grid grid-cols-1 gap-4">
            <?php foreach (array_reverse($orders) as $os): ?>
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                    <div class="flex flex-col sm:flex-row justify-between gap-4 mb-4">
                        <div>
                            <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded"><?= $os['id'] ?></span>
                            <h4 class="text-xl font-bold text-slate-800 mt-1"><?= htmlspecialchars($os['customer']) ?></h4>
                            <p class="text-xs text-slate-400"><?= htmlspecialchars($os['address']) ?></p>
                        </div>
                        <div class="flex gap-2 h-fit">
                            <button onclick='prepareEdit(<?= json_encode($os) ?>)' class="p-3 bg-slate-50 text-slate-400 rounded-xl hover:bg-blue-600 hover:text-white transition">✏️</button>
                            <a href="actions.php?method=deleteOS&id=<?= $os['id'] ?>" onclick="return confirm('Excluir?')" class="p-3 bg-slate-50 text-slate-400 rounded-xl hover:bg-red-500 hover:text-white transition">✕</a>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <?php foreach (($os['items'] ?? []) as $id => $qty):
                            $name = "Item";
                            foreach ($inventory as $inv) if ($inv['id'] == $id) $name = $inv['name']; ?>
                            <span class="bg-slate-100 px-3 py-1 rounded-full text-[10px] font-bold text-slate-500"><?= $qty ?>x <?= $name ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
    const container = document.getElementById('items-container');

    document.getElementById('add-item-trigger').addEventListener('change', function() {
        const opt = this.options[this.selectedIndex];
        if (!opt.value) return;
        addItemRow(opt.value, opt.dataset.name, 1, opt.dataset.max);
        this.value = "";
    });

    function addItemRow(id, name, qty, max) {
        if (document.querySelector(`#items-container input[value="${id}"]`)) return;
        const div = document.createElement('div');
        div.className = "flex items-center gap-2 bg-white p-2 rounded-xl border border-blue-100 animate-fadeIn";
        div.innerHTML = `
        <input type="hidden" name="eq_ids[]" value="${id}">
        <span class="flex-1 text-[11px] font-bold text-slate-700 truncate">${name}</span>
        <input type="number" name="eq_qtys[]" value="${qty}" min="1" max="${max}" 
               oninput="if(parseInt(this.value) > ${max}) { alert('Estoque insuficiente!'); this.value = ${max}; }"
               class="w-12 p-1 bg-slate-50 rounded text-xs text-center border-none font-bold text-blue-600">
        <button type="button" onclick="this.parentElement.remove()" class="text-red-400 px-2 font-bold">✕</button>`;
        container.appendChild(div);
    }

    function prepareEdit(os) {
        const form = document.getElementById('os-form');
        form.action = "actions.php?method=updateOS";
        document.getElementById('form-title').innerHTML = "✏️ Editando OS";
        document.getElementById('os_id').value = os.id;
        document.getElementById('customer').value = os.customer;
        document.getElementById('address').value = os.address;
        document.getElementById('reason').value = os.reason;
        container.innerHTML = "";
        Object.entries(os.items).forEach(([id, qty]) => {
            const opt = document.querySelector(`#add-item-trigger option[value="${id}"]`);
            const name = opt ? opt.dataset.name : "Item";
            const currentStock = opt ? parseInt(opt.dataset.max) : 0;
            addItemRow(id, name, qty, currentStock + parseInt(qty));
        });
        form.scrollIntoView({
            behavior: 'smooth'
        });
    }
</script>