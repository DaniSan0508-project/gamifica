# PRD & Implementation Roadmap — Gamifica SaaS (Multi-tenant)

## Overview
Plataforma SaaS onde múltiplas empresas podem criar programas de incentivo. Cada empresa tem seus colaboradores, missões e loja de prêmios. O isolamento de dados é garantido via `company_id`.

**Stack:** Laravel 13, Livewire 4, Tailwind CSS v4, PostgreSQL, Pest 4.

---

## ✅ Fase 1: Fundação Multi-tenant & Auth
**Foco:** Garantir que o "Prédio" suporte vários "Apartamentos" (Empresas) isolados.
- [x] **Database Schema:** UUIDs para IDs, tabela `companies` criada, `users` atualizada com `company_id`, `role` e `points_balance`.
- [x] **Tenant Isolation:** Implementada Trait `HasCompany` e Global Scope `CompanyScope` para isolamento total de dados.
- [x] **Autenticação:** Login único com redirecionamento baseado em Role (Admin -> Gestão / Employee -> Player).
- [x] **Testes:** Validação de isolamento e fluxos de login (`TenantAuthTest`).

## ✅ Fase 2: Gestão de Gamificação (Painel Admin)
**Foco:** Onde o RH configura as regras do jogo.
- [x] **Missões:** CRUD completo de Missões com regras de bônus e status ativo/inativo.
- [x] **Rewards:** CRUD de Prêmios com controle de custo em pontos, estoque e upload de imagens.
- [x] **Segurança:** Middleware `AdminMiddleware` restringindo o acesso a gestores.
- [x] **Testes:** Validação de CRUDs e isolamento por empresa (`MissionTest`, `RewardTest`).

## ✅ Fase 3: Jornada do Colaborador (Player UX)
**Foco:** A interface lúdica para quem ganha os pontos.
- [x] **Dashboard:** Visualização de saldo em tempo real e lista de missões disponíveis.
- [x] **Point Service:** Lógica atômica para ganho e gasto de pontos com registro de transações.
- [x] **Resgate Simples:** Interface inicial para troca de pontos por prêmios.
- [x] **Testes:** Validação de transações e saldo (`MissionCompletionTest`).

## ✅ Fase 4: Escalabilidade & Social
**Foco:** Funcionalidades que tornam o sistema robusto e viciante.
- [x] **Ranking (Leaderboard):** Classificação competitiva por empresa com cache de alta performance.
- [x] **Feed da Empresa:** Log de atividades sociais (conclusão de missões e resgates).
- [x] **Testes:** Garantia de que o ranking não mistura dados entre empresas (`LeaderboardTest`).

## ✅ Fase 5: Gestão de Resgates e Vouchers
**Foco:** Ciclo completo de logística e fulfillment.
- [x] **Model Orders:** Registro formal de pedidos de resgate.
- [x] **Vouchers:** Geração automática de códigos únicos para retirada física.
- [x] **Painel de Pedidos:** Interface Admin para marcar prêmios como "Entregues".
- [x] **Meus Resgates:** Carteira de vouchers para o colaborador.

## ✅ Fase 6: Analytics & Insights para Gestores
**Foco:** Painel de controle orientado a dados.
- [x] **KPI Cards:** Métricas de total de pontos distribuídos, gastos, usuários ativos e pedidos pendentes.
- [x] **Quick Actions:** Atalhos produtivos no dashboard admin.
- [x] **Layout Premium:** Reorganização do painel admin para facilitar a tomada de decisão.

## ✅ Fase 7: Feedback e Reconhecimento (Kudos)
**Foco:** Cultura de gratidão e reconhecimento peer-to-peer.
- [x] **Sistema de Kudos:** Envio de mensagens de reconhecimento entre colegas.
- [x] **Bônus Admin:** Capacidade de administradores anexarem pontos extras a elogios.
- [x] **Privacidade:** Colaboradores só vêem seus próprios Kudos; Admins gerenciam todos.

## ✅ Fase 8: Correção e Estabilidade do Ranking
**Foco:** Garantir dados em tempo real e sem falhas de cache.
- [x] **User Observer:** Invalidação automática de cache do ranking em qualquer alteração de saldo.
- [x] **Filtro de Papel:** Exclusão de administradores do ranking competitivo.

## ✅ Fase 9: Refinamento de UI/UX (Design "Digital Kineticist")
**Foco:** Identidade visual premium, moderna e cinética.
- [x] **No-Line Rule:** Remoção de bordas 1px, uso de profundidade e sombras ambientes.
- [x] **Tipografia:** Implementação de Space Grotesk, Inter e Plus Jakarta Sans.
- [x] **Glassmorphism:** Camadas de vidro e desfoque de fundo no cabeçalho e modais.

## ✅ Fase 10: Navegação Responsiva & Mobile UX
**Foco:** Experiência perfeita em smartphones e tablets.
- [x] **Menu Hamburger:** Menu mobile retrátil com Alpine.js.
- [x] **Layout Adaptativo:** Cabeçalho e dashboards otimizados para telas pequenas.

## ✅ Fase 11: Correção de Imagens e Perfis com Avatares
**Foco:** Personalização e correção técnica.
- [x] **Storage Link:** Resolução do problema de exibição das imagens dos produtos.
- [x] **Perfil de Usuário:** Tela para alteração de Nome, E-mail e Upload de Foto (Avatar).
- [x] **Integração Visual:** Avatares exibidos no Feed, Ranking e Navbar.

---

## 🚀 Próximas Fases Sugeridas
- [ ] **Fase 12: Sistema de Níveis (Levels):** Gamificação por XP acumulado.
- [ ] **Fase 13: Notificações:** Avisos por e-mail/push para novos kudos ou prêmios entregues.
- [ ] **Fase 14: Relatórios em PDF:** Exportação de métricas para o RH.
