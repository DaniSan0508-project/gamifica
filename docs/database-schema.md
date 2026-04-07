Abaixo, apresento o Schema estruturado para PostgreSQL, focado em integridade referencial e performance.

1. Diagrama de Relacionamento (ERD)
2. SQL Schema (PostgreSQL)
Aqui está o código DDL (Data Definition Language) que você pode rodar no seu PG Admin ou via migrations.

Core: Empresas e Planos
SQL
CREATE TABLE companies (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    plan_type VARCHAR(50) DEFAULT 'free', -- 'free', 'pro', 'enterprise'
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX idx_company_slug ON companies(slug);
Usuários e Permissões
SQL
CREATE TABLE users (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    company_id UUID NOT NULL REFERENCES companies(id) ON DELETE CASCADE,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password_hash TEXT NOT NULL,
    role VARCHAR(20) DEFAULT 'employee', -- 'admin', 'employee'
    points_balance INT DEFAULT 0,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(company_id, email), -- Email único dentro da mesma empresa
    UNIQUE(company_id, username)
);

CREATE INDEX idx_users_company ON users(company_id);
Gamificação: Missões e Prêmios
SQL
CREATE TABLE missions (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    company_id UUID NOT NULL REFERENCES companies(id) ON DELETE CASCADE,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    points_reward INT NOT NULL CHECK (points_reward > 0),
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE rewards (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    company_id UUID NOT NULL REFERENCES companies(id) ON DELETE CASCADE,
    title VARCHAR(255) NOT NULL,
    cost INT NOT NULL CHECK (cost > 0),
    stock INT DEFAULT 0,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);
Transações e Auditoria (Obrigatório para Escala)
Aqui é onde evitamos erros de saldo. Nunca altere o saldo do usuário sem criar um registro aqui.

SQL
CREATE TABLE point_transactions (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    company_id UUID NOT NULL REFERENCES companies(id),
    user_id UUID NOT NULL REFERENCES users(id),
    amount INT NOT NULL, -- Positivo para ganho, negativo para gasto
    transaction_type VARCHAR(50), -- 'mission_complete', 'reward_redeem', 'admin_adjustment'
    description TEXT,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX idx_transactions_user ON point_transactions(user_id);
3. Estratégias de Escalabilidade no PostgreSQL
1. Índices Compostos
Sempre que você fizer uma busca, o PostgreSQL deve filtrar por empresa primeiro. Por isso, os índices devem ser:
CREATE INDEX idx_mission_search ON missions (company_id, is_active);

2. Row Level Security (RLS) - Segurança de Elite
O PostgreSQL tem uma função nativa para garantir que um usuário nunca veja dados de outra empresa, mesmo que o desenvolvedor esqueça o WHERE company_id = ? no código.

SQL
-- Ativa RLS na tabela
ALTER TABLE users ENABLE ROW LEVEL SECURITY;

-- Cria uma política onde o usuário só vê o que pertence à sua empresa
CREATE POLICY tenant_isolation_policy ON users
    USING (company_id = current_setting('app.current_company_id')::uuid);
3. Particionamento (Opcional para o futuro)
Se você chegar a milhões de transações, o PostgreSQL permite Particionamento por Lista. Você pode criar partições físicas no disco baseadas no company_id (ou grupos de empresas), tornando as queries extremamente rápidas para grandes clientes.

4. Dica de Implementação: Transações Atômicas
Ao resgatar um prêmio, use BEGIN e COMMIT. No Postgres, você pode usar o comando UPDATE ... RETURNING para garantir que o saldo foi atualizado antes de confirmar o pedido:

SQL
BEGIN;
  -- Tenta subtrair os pontos apenas se o saldo for suficiente
  UPDATE users 
  SET points_balance = points_balance - 500 
  WHERE id = 'user_id' AND points_balance >= 500;
  
  -- Se o UPDATE afetou 1 linha, insere o pedido
  INSERT INTO orders ...;
COMMIT;
Este schema está pronto para ser escalado. O que acha de avançarmos para a lógica de integração/API para que sistemas externos enviem pontos para essas missões?
