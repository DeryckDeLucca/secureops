<?php 
$inventory = $engine->getInventory();
$orders = $engine->getOrders();
?>

<div class="flex flex-col lg:flex-row h-full overflow-hidden">
    
    <div class="w-full lg:w-[450px] h-full overflow-y-auto custom-scroll p-6 lg:p-10 shrink-0 border-r border-slate-100">
        <div class="bento-card p-8 shadow-sm border-slate-200">
            <div class="mb-8">
                <h2 id="form-title" class="text-2xl font-extrabold text-slate-900 tracking-tight">Registro de OS</h2>
                <div class="w-12 h-1 bg-blue-600 mt-2 rounded-full"></div>
            </div>
            
            <form id="os-form" action="actions.php?method=createOS" method="POST" class="space-y-6">
                <input type="hidden" name="os_id" id="os_id">
                
                <div class="space-y-5">
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Cliente</label>
                        <input type="text" name="customer" id="customer" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 focus:bg-white focus:border-blue-600 focus:ring-4 ring-blue-50 outline-none transition-all font-semibold">
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Endereço de Instalação</label>
                        <input type="text" name="address" id="address" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 focus:bg-white focus:border-blue-600 focus:ring-4 ring-blue-50 outline-none transition-all">
                    </div>

                    <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 shadow-inner">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest block mb-4">Materiais do Projeto</label>
                        <div id="items-container" class="space-y-3 mb-4"></div>
                        
                        <select id="add-item-trigger" class="w-full bg-white border border-slate-300 p-3 rounded-xl text-xs font-bold text-slate-700 focus:ring-2 ring-blue-200 outline-none cursor-pointer hover:border-blue-400 transition">
                            <option value="">+ ADICIONAR EQUIPAMENTO</option>
                            <?php foreach($inventory as $item): if($item['quantity'] <= 0) continue; ?>
                                <option value="<?= $item['id'] ?>" data-name="<?= $item['name'] ?>" data-max="<?= $item['quantity'] ?>">
                                    <?= $item['name'] ?> (Disp: <?= $item['quantity'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Relatório de Visita</label>
                        <textarea name="reason" id="reason" rows="4" placeholder="Detalhes técnicos..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:bg-white focus:border-blue-600 outline-none transition-all resize-none"></textarea>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-blue-600 text-white font-extrabold py-4 rounded-2xl hover:bg-slate-900 transition-all shadow-xl shadow-blue-500/20 active:scale-95">
                        FINALIZAR REGISTRO
                    </button>
                    <button type="button" onclick="location.reload()" id="btn-cancel" class="hidden w-full mt-3 text-slate-400 text-xs font-bold py-2 hover:text-red-500 uppercase tracking-tighter">
                        Cancelar Edição
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="flex-1 h-full overflow-y-auto custom-scroll p-6 lg:p-10">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-sm font-black text-slate-400 uppercase tracking-[0.3em]">Histórico de Operações</h3>
            <div class="h-px flex-1 bg-slate-200 mx-6"></div>
        </div>

        <div class="grid grid-cols-1 gap-6 pb-20">
            <?php if(empty($orders)): ?>
                <div class="bento-card p-20 text-center text-slate-300 border-dashed border-2">Nenhum registro encontrado.</div>
            <?php endif; ?>

            <?php foreach(array_reverse($orders) as $os): ?>
            <div class="bento-card p-8 group hover:border-blue-200 transition-colors">
                <div class="flex flex-col md:flex-row justify-between gap-6">
                    <div class="flex-1">
                        <div class="flex items-center gap-4 mb-4">
                            <span class="mono text-[10px] font-bold bg-blue-600 text-white px-3 py-1 rounded-full uppercase"><?= $os['id'] ?></span>
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest"><?= $os['date'] ?></span>
                        </div>
                        <h4 class="text-2xl font-black text-slate-800 mb-2 leading-tight"><?= htmlspecialchars($os['customer']) ?></h4>
                        <div class="flex items-center gap-2 text-slate-500 text-xs mb-6">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2"/></svg>
                            <?= htmlspecialchars($os['address']) ?>
                        </div>
                        
                        <div class="flex flex-wrap gap-2">
                            <?php foreach(($os['items'] ?? []) as $id => $qty): 
                                $name = "Item"; foreach($inventory as $inv) if($inv['id'] == $id) $name = $inv['name']; ?>
                                <span class="text-[10px] font-black bg-slate-50 text-slate-600 px-3 py-2 rounded-lg border border-slate-100">
                                    <span class="text-blue-600 mr-1"><?= $qty ?>x</span> <?= $name ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="w-full md:w-64 flex flex-col justify-between border-t md:border-t-0 md:border-l border-slate-100 pt-6 md:pt-0 md:pl-8">
                        <p class="text-xs text-slate-500 leading-relaxed italic mb-6">"<?= htmlspecialchars($os['reason'] ?: 'Sem observações.') ?>"</p>
                        <div class="flex justify-end gap-6 opacity-40 group-hover:opacity-100 transition-opacity">
                            <button onclick='prepareEdit(<?= json_encode($os) ?>)' class="text-[10px] font-black text-slate-900 hover:text-blue-600 uppercase tracking-widest">Editar</button>
                            <a href="actions.php?method=deleteOS&id=<?= $os['id'] ?>" onclick="return confirm('Estornar OS?')" class="text-[10px] font-black text-red-500 hover:text-red-700 uppercase tracking-widest">Apagar</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
// Mantive o JS original apenas corrigindo o scroll de edição para a coluna específica
const container = document.getElementById('items-container');

document.getElementById('add-item-trigger').addEventListener('change', function() {
    const opt = this.options[this.selectedIndex];
    if(!opt.value) return;
    addItemRow(opt.value, opt.dataset.name, 1, opt.dataset.max);
    this.value = "";
});

function addItemRow(id, name, qty, max) {
    if(document.querySelector(`#items-container input[value="${id}"]`)) return;
    const div = document.createElement('div');
    div.className = "flex items-center justify-between bg-white p-3 rounded-xl border border-slate-200 shadow-sm animate-fadeIn";
    div.innerHTML = `
        <input type="hidden" name="eq_ids[]" value="${id}">
        <span class="text-xs font-bold text-slate-700 truncate mr-2">${name}</span>
        <div class="flex items-center gap-3">
            <input type="number" name="eq_qtys[]" value="${qty}" min="1" max="${max}" 
                   oninput="if(parseInt(this.value) > ${max}) { this.value = ${max}; }"
                   class="w-12 bg-slate-50 border-none rounded-lg p-1 text-center text-xs font-black text-blue-600 focus:ring-2 ring-blue-100">
            <button type="button" onclick="this.parentElement.parentElement.remove()" class="text-slate-300 hover:text-red-500 transition">✕</button>
        </div>`;
    container.appendChild(div);
}

function prepareEdit(os) {
    const form = document.getElementById('os-form');
    form.action = "actions.php?method=updateOS";
    document.getElementById('form-title').innerHTML = "Editando OS";
    document.getElementById('os_id').value = os.id;
    document.getElementById('customer').value = os.customer;
    document.getElementById('address').value = os.address;
    document.getElementById('reason').value = os.reason;
    document.getElementById('btn-cancel').classList.remove('hidden');
    container.innerHTML = "";
    Object.entries(os.items).forEach(([id, qty]) => {
        const opt = document.querySelector(`#add-item-trigger option[value="${id}"]`);
        const name = opt ? opt.dataset.name : "Item Registrado";
        const currentStock = opt ? parseInt(opt.dataset.max) : 0;
        addItemRow(id, name, qty, currentStock + parseInt(qty));
    });
    // Rola apenas a coluna do formulário para o topo
    document.querySelector('.lg\\:w-\\[450px\\]').scrollTo({ top: 0, behavior: 'smooth' });
}
</script>