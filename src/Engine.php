<?php

namespace SecureOps;

class Engine
{
    private $inventoryFile = __DIR__ . '/../data/inventory.json';
    private $ordersFile = __DIR__ . '/../data/orders.json';

    private function load($file)
    {
        if (!file_exists($file)) return [];
        return json_decode(file_get_contents($file), true) ?: [];
    }

    public function getInventory()
    {
        return $this->load($this->inventoryFile);
    }
    public function getOrders()
    {
        return $this->load($this->ordersFile);
    }

    public function saveEquipment($data)
    {
        $items = $this->getInventory();
        if (!isset($data['id']) || empty($data['id'])) {
            $data['id'] = time();
            $items[] = $data;
        } else {
            foreach ($items as &$item) {
                if ($item['id'] == $data['id']) {
                    $item['name'] = $data['name'];
                    $item['min_stock'] = (int)$data['min_stock'];
                    $item['quantity'] = (int)$data['quantity'];
                }
            }
        }
        file_put_contents($this->inventoryFile, json_encode(array_values($items), JSON_PRETTY_PRINT));
    }

    public function createOS($osData)
    {
        $orders = $this->getOrders();
        $inventory = $this->getInventory();
        $itemsUsed = $osData['items'] ?? [];

        if (empty($itemsUsed)) return false;

        foreach ($inventory as &$invItem) {
            if (isset($itemsUsed[$invItem['id']])) {
                if ($invItem['quantity'] < $itemsUsed[$invItem['id']]) return false;
                $invItem['quantity'] -= $itemsUsed[$invItem['id']];
            }
        }

        $osData['id'] = "OS-" . date('Ymd-His');
        $osData['date'] = date('d/m/Y H:i');
        $orders[] = $osData;

        $this->saveAll($orders, $inventory);
        return true;
    }

    public function updateOS($id, $newData)
    {
        $orders = $this->getOrders();
        $inventory = $this->getInventory();
        $osIndex = null;

        // 1. Achar a OS e devolver o estoque antigo temporariamente para validar
        foreach ($orders as $key => $os) {
            if ($os['id'] === $id) {
                $osIndex = $key;
                foreach ($os['items'] as $itemId => $qty) {
                    foreach ($inventory as &$invItem) {
                        if ($invItem['id'] == $itemId) $invItem['quantity'] += $qty;
                    }
                }
                break;
            }
        }

        if ($osIndex === null) return false;

        // 2. Validar se o novo estoque (após devolução) suporta a nova edição
        foreach ($newData['items'] as $itemId => $qty) {
            $found = false;
            foreach ($inventory as &$invItem) {
                if ($invItem['id'] == $itemId) {
                    if ($invItem['quantity'] < $qty) return false;
                    $invItem['quantity'] -= $qty;
                    $found = true;
                }
            }
            if (!$found) return false;
        }

        $newData['id'] = $id;
        $newData['date'] = $orders[$osIndex]['date'] . " (Editada)";
        $orders[$osIndex] = $newData;

        $this->saveAll($orders, $inventory);
        return true;
    }

    public function deleteOS($id)
    {
        $orders = $this->getOrders();
        $inventory = $this->getInventory();
        $targetOS = null;

        foreach ($orders as $key => $os) {
            if ($os['id'] === $id) {
                $targetOS = $os;
                unset($orders[$key]);
                break;
            }
        }

        if ($targetOS) {
            // Devolve itens ao inventário ao excluir a OS
            foreach ($targetOS['items'] as $itemId => $qty) {
                foreach ($inventory as &$invItem) {
                    if ($invItem['id'] == $itemId) $invItem['quantity'] += $qty;
                }
            }
            $this->saveAll($orders, $inventory);
            return true;
        }
        return false;
    }

    private function saveAll($orders, $inventory)
    {
        file_put_contents($this->ordersFile, json_encode(array_values($orders), JSON_PRETTY_PRINT));
        file_put_contents($this->inventoryFile, json_encode(array_values($inventory), JSON_PRETTY_PRINT));
    }
}
