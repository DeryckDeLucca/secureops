<?php
namespace SecureOps;

/**
 * Classe que representa um Equipamento no Inventário
 */
class Equipment {
    public function __construct(
        public int $id,
        public string $name,
        public string $category,
        public int $quantity,
        public int $min_stock
    ) {}

    // Lógica para verificar se o item precisa de reposição
    public function needsRestock(): bool {
        return $this->quantity <= $this->min_stock;
    }
}

/**
 * Classe que representa uma Ordem de Serviço (Visita Técnica)
 */
class ServiceOrder {
    public function __construct(
        public string $id,
        public string $customer,
        public string $address,
        public int $equipment_id,
        public int $qty_used,
        public string $reason,
        public string $date
    ) {}

    // Formata o ID para exibição (ex: OS-2024...)
    public function getFormattedId(): string {
        return strtoupper($this->id);
    }
}