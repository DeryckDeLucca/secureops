<?php
require_once 'src/Engine.php';
$engine = new \SecureOps\Engine();
$method = $_GET['method'] ?? '';

// Caminho absoluto para evitar erros de arquivo
$inventoryFile = __DIR__ . '/data/inventory.json';

switch ($method) {

    // --- GESTÃO DE ORDENS DE SERVIÇO ---

    case 'createOS':
    case 'updateOS':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $items = [];
            if (isset($_POST['eq_ids'])) {
                foreach ($_POST['eq_ids'] as $idx => $id) {
                    $items[$id] = (int)$_POST['eq_qtys'][$idx];
                }
            }
            $data = [
                'customer' => $_POST['customer'],
                'address'  => $_POST['address'],
                'reason'   => $_POST['reason'],
                'items'    => $items
            ];

            // Se for createOS, chama create. Se for updateOS, chama update.
            $res = ($method === 'createOS')
                ? $engine->createOS($data)
                : $engine->updateOS($_POST['os_id'], $data);

            if (!$res) {
                echo "<script>alert('Erro: Estoque insuficiente!'); window.history.back();</script>";
                exit;
            }
        }
        header("Location: index.php?page=os");
        exit;

    case 'deleteOS':
        if (isset($_GET['id'])) {
            $engine->deleteOS($_GET['id']);
        }
        header("Location: index.php?page=os");
        exit;


        // --- GESTÃO DE EQUIPAMENTOS (ESTOQUE) ---

    case 'saveEquipment':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $engine->saveEquipment([
                'name'      => $_POST['name'],
                'quantity'  => (int)$_POST['quantity'],
                'min_stock' => (int)$_POST['min_stock']
            ]);
        }
        header("Location: index.php?page=estoque");
        exit;

    case 'updateFull':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $inventory = $engine->getInventory();
            foreach ($inventory as &$item) {
                if ($item['id'] == $_POST['id']) {
                    $item['name']      = $_POST['name'];
                    $item['min_stock'] = (int)$_POST['min_stock'];
                }
            }
            file_put_contents($inventoryFile, json_encode(array_values($inventory), JSON_PRETTY_PRINT));
        }
        header("Location: index.php?page=estoque");
        exit;

    case 'updateQty':
        $id = $_GET['id'];
        $change = (int)$_GET['change'];
        $inventory = $engine->getInventory();
        foreach ($inventory as &$item) {
            if ($item['id'] == $id) {
                $item['quantity'] = max(0, $item['quantity'] + $change);
            }
        }
        file_put_contents($inventoryFile, json_encode(array_values($inventory), JSON_PRETTY_PRINT));
        header("Location: index.php?page=estoque");
        exit;

    case 'deleteEquipment':
        $inventory = array_filter($engine->getInventory(), fn($i) => $i['id'] != $_GET['id']);
        file_put_contents($inventoryFile, json_encode(array_values($inventory), JSON_PRETTY_PRINT));
        header("Location: index.php?page=estoque");
        exit;

    default:
        header("Location: index.php");
        exit;
}
