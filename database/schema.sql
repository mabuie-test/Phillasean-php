CREATE TABLE users (
  id           INT AUTO_INCREMENT PRIMARY KEY,
  nome         VARCHAR(100) NOT NULL,
  email        VARCHAR(150) UNIQUE NOT NULL,
  senha_hash   VARCHAR(255) NOT NULL,
  is_admin     TINYINT(1) DEFAULT 0,
  created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE solicitacoes (
  id           INT AUTO_INCREMENT PRIMARY KEY,
  user_id      INT NOT NULL,
  detalhes     TEXT,
  status       VARCHAR(50) DEFAULT 'pendente',
  created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE faturas (
  id              INT AUTO_INCREMENT PRIMARY KEY,
  solicitacao_id  INT NOT NULL,
  filepath        VARCHAR(255) NOT NULL,
  created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (solicitacao_id) REFERENCES solicitacoes(id)
);

CREATE TABLE auditoria (
  id              INT AUTO_INCREMENT PRIMARY KEY,
  entidade        VARCHAR(50),
  entidade_id     INT,
  acao            VARCHAR(50),
  user_performed  INT,
  detalhe         TEXT,
  created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
