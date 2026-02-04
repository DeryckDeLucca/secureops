# 🛡️ SecureOps - Gerenciamento Técnico

O **SecureOps** é uma plataforma simplificada e funcional desenvolvida para empresas de segurança eletrônica. O sistema integra o controle de inventário com a emissão inteligente de Ordens de Serviço (OS), focado em agilidade operacional e uma interface intuitiva de alto desempenho.

---

## 🛠️ Tecnologias Utilizadas

O sistema foi construído com uma stack leve e nativa, garantindo rapidez no carregamento e facilidade de manutenção:

* **Back-end:** `PHP 8.x` (Arquitetura funcional e processamento de dados).
* **Front-end:** `Tailwind CSS 3.4` (Design moderno através de classes utilitárias).
* **Dinâmica:** `JavaScript (Vanilla)` (Manipulação de DOM, cálculos em tempo real e formulários dinâmicos).
* **Tipografia:** `Plus Jakarta Sans` para interface e `JetBrains Mono` para dados técnicos.

---

## 📋 Funcionalidades Principais

| Funcionalidade | Descrição |
| :--- | :--- |
| **Painel de Controle** | Visão geral dos ativos e resumo de atividades recentes. |
| **Gestão de OS** | Registro de ordens com seleção dinâmica de materiais e relatório de visita. |
| **Inventário em Tempo Real** | Controle de estoque com baixa automática e indicadores visuais de quantidade. |
| **Edição Dinâmica** | Interface que permite alternar entre criação e ajuste de registros sem recarregar a página. |

---

## 🛠️ Instalação e Execução

Clone o repositório:

| **git clone https://github.com/DeryckDeLucca/secureops.git** |

Requisitos: Certifique-se de que possui o PHP 8.0+ instalado em sua máquina ou servidor.

Servidor Local: Navegue até a pasta raiz do projeto via terminal e execute:

| **php -S localhost:8000** |

---

## 🏗️ Estrutura de Arquivos
```text
├── actions.php          # Processamento de formulários e métodos back-end
├── index.php            # Ponto de entrada e controlador de rotas/layout
├── src/
│   └── Engine.php       # Core do sistema (Lógica de negócio e persistência)
├── views/               # Camada de visualização (UI)
│   ├── dashboard.php
│   ├── estoque.php
│   └── os.php
└── data/                # Armazenamento dos dados (JSON/Database)
---