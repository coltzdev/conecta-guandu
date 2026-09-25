-- ============================================================
-- CONECTA GUANDU — Estrutura do banco de dados
-- ============================================================
-- Script da versão acadêmica com as 7 tabelas implementadas.
--
-- Ambiente: MySQL Community Server 8.0.42, porta 3306
-- ============================================================

CREATE DATABASE conecta_guandu
CHARACTER SET utf8mb4
COLLATE utf8mb4_0900_ai_ci;

USE conecta_guandu;


-- ============================================================
-- 1. categorias
-- ============================================================
CREATE TABLE categorias (
    id      INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nome    VARCHAR(100) NOT NULL,
    icone   VARCHAR(50)  NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_categorias_nome (nome)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- ============================================================
-- 2. profissoes
-- ============================================================
CREATE TABLE profissoes (
    id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
    categoria_id    INT UNSIGNED NOT NULL,
    nome            VARCHAR(100) NOT NULL,
    slug            VARCHAR(100) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_profissoes_slug (slug),
    KEY idx_profissoes_categoria (categoria_id),
    CONSTRAINT fk_profissoes_categoria
        FOREIGN KEY (categoria_id) REFERENCES categorias(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- ============================================================
-- 3. profissionais
-- ============================================================
-- O status de publicação deve ser informado em cada cadastro.
CREATE TABLE profissionais (
    id                    INT UNSIGNED NOT NULL AUTO_INCREMENT,
    profissao_id          INT UNSIGNED NULL,
    profissao_sugerida    VARCHAR(120) NULL,
    nome                  VARCHAR(120) NOT NULL,
    foto                  VARCHAR(255) NULL,
    bairro                VARCHAR(100) NULL,
    cidade                VARCHAR(100) NULL,
    experiencia           VARCHAR(50)  NULL,
    descricao             TEXT         NULL,
    area_atendimento      VARCHAR(255) NULL,
    telefone              VARCHAR(25)  NULL,
    whatsapp              VARCHAR(20)  NULL,
    instagram             VARCHAR(255) NULL,
    status_publicacao     TINYINT      NOT NULL,
    data_criacao          DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    data_atualizacao      DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP
                                        ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_profissionais_profissao (profissao_id),
    CONSTRAINT fk_profissionais_profissao
        FOREIGN KEY (profissao_id) REFERENCES profissoes(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- ============================================================
-- 4. servicos_oferecidos
-- ============================================================
CREATE TABLE servicos_oferecidos (
    id                  INT UNSIGNED NOT NULL AUTO_INCREMENT,
    profissional_id     INT UNSIGNED NOT NULL,
    descricao           VARCHAR(200) NOT NULL,
    ordem_exibicao      SMALLINT UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    KEY idx_servicos_profissional (profissional_id),
    CONSTRAINT fk_servicos_profissional
        FOREIGN KEY (profissional_id) REFERENCES profissionais(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- ============================================================
-- 5. formas_atendimento
-- ============================================================
CREATE TABLE formas_atendimento (
    id                  INT UNSIGNED NOT NULL AUTO_INCREMENT,
    profissional_id     INT UNSIGNED NOT NULL,
    descricao           VARCHAR(150) NOT NULL,
    ordem_exibicao      SMALLINT UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    KEY idx_formas_profissional (profissional_id),
    CONSTRAINT fk_formas_profissional
        FOREIGN KEY (profissional_id) REFERENCES profissionais(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- ============================================================
-- 6. horarios_atendimento
-- ============================================================
CREATE TABLE horarios_atendimento (
    id                  INT UNSIGNED NOT NULL AUTO_INCREMENT,
    profissional_id     INT UNSIGNED NOT NULL,
    periodo_dia         VARCHAR(80) NOT NULL,
    horario              VARCHAR(80) NOT NULL,
    ordem_exibicao      SMALLINT UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    KEY idx_horarios_profissional (profissional_id),
    CONSTRAINT fk_horarios_profissional
        FOREIGN KEY (profissional_id) REFERENCES profissionais(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- ============================================================
-- 7. portfolio
-- ============================================================
CREATE TABLE portfolio (
    id                  INT UNSIGNED NOT NULL AUTO_INCREMENT,
    profissional_id     INT UNSIGNED NOT NULL,
    caminho_imagem      VARCHAR(255) NOT NULL,
    ordem_exibicao      SMALLINT UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    KEY idx_portfolio_profissional (profissional_id),
    CONSTRAINT fk_portfolio_profissional
        FOREIGN KEY (profissional_id) REFERENCES profissionais(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- ============================================================
-- Conferência da estrutura
-- ============================================================
SELECT DATABASE();
SHOW TABLES;

-- ============================================================
-- SEED — 7 categorias (mesmos ícones já usados no menu da Home)
-- ============================================================
INSERT INTO categorias (nome, icone) VALUES
('Serviços domésticos',       'bi-house-door'),
('Reformas e reparos',        'bi-tools'),
('Beleza e moda',             'bi-scissors'),
('Automotivo',                'bi-car-front'),
('Assistência e tecnologia',  'bi-laptop'),
('Aulas',                     'bi-book'),
('Festas e eventos',          'bi-balloon');


-- ============================================================
-- SEED — 25 profissões 
-- ============================================================

-- Serviços domésticos
INSERT INTO profissoes (categoria_id, nome, slug)
SELECT id, 'Faxineiro(a)', 'faxineiro' FROM categorias WHERE nome = 'Serviços domésticos';
INSERT INTO profissoes (categoria_id, nome, slug)
SELECT id, 'Babá', 'baba' FROM categorias WHERE nome = 'Serviços domésticos';
INSERT INTO profissoes (categoria_id, nome, slug)
SELECT id, 'Cuidador(a) de pessoas', 'cuidador' FROM categorias WHERE nome = 'Serviços domésticos';

-- Reformas e reparos
INSERT INTO profissoes (categoria_id, nome, slug)
SELECT id, 'Eletricista', 'eletricista' FROM categorias WHERE nome = 'Reformas e reparos';
INSERT INTO profissoes (categoria_id, nome, slug)
SELECT id, 'Encanador', 'encanador' FROM categorias WHERE nome = 'Reformas e reparos';
INSERT INTO profissoes (categoria_id, nome, slug)
SELECT id, 'Pedreiro', 'pedreiro' FROM categorias WHERE nome = 'Reformas e reparos';
INSERT INTO profissoes (categoria_id, nome, slug)
SELECT id, 'Pintor', 'pintor' FROM categorias WHERE nome = 'Reformas e reparos';
INSERT INTO profissoes (categoria_id, nome, slug)
SELECT id, 'Montador(a) de móveis', 'montador-moveis' FROM categorias WHERE nome = 'Reformas e reparos';
INSERT INTO profissoes (categoria_id, nome, slug)
SELECT id, 'Arquiteto(a)', 'arquiteto' FROM categorias WHERE nome = 'Reformas e reparos';
INSERT INTO profissoes (categoria_id, nome, slug)
SELECT id, 'Engenheiro(a)', 'engenheiro' FROM categorias WHERE nome = 'Reformas e reparos';

-- Beleza e moda
INSERT INTO profissoes (categoria_id, nome, slug)
SELECT id, 'Costureiro(a)', 'costureiro' FROM categorias WHERE nome = 'Beleza e moda';
INSERT INTO profissoes (categoria_id, nome, slug)
SELECT id, 'Barbeiro(a)', 'barbeiro' FROM categorias WHERE nome = 'Beleza e moda';
INSERT INTO profissoes (categoria_id, nome, slug)
SELECT id, 'Maquiador(a)', 'maquiador' FROM categorias WHERE nome = 'Beleza e moda';
INSERT INTO profissoes (categoria_id, nome, slug)
SELECT id, 'Manicure/Pedicure', 'manicure-pedicure' FROM categorias WHERE nome = 'Beleza e moda';

-- Automotivo
INSERT INTO profissoes (categoria_id, nome, slug)
SELECT id, 'Lavador(a) de veículos', 'lavador-veiculos' FROM categorias WHERE nome = 'Automotivo';
INSERT INTO profissoes (categoria_id, nome, slug)
SELECT id, 'Pintor(a) automotivo', 'pintor-automotivo' FROM categorias WHERE nome = 'Automotivo';

-- Assistência e tecnologia
INSERT INTO profissoes (categoria_id, nome, slug)
SELECT id, 'Técnico(a) de informática', 'tecnico-informatica' FROM categorias WHERE nome = 'Assistência e tecnologia';
INSERT INTO profissoes (categoria_id, nome, slug)
SELECT id, 'Técnico(a) de celulares', 'tecnico-celulares' FROM categorias WHERE nome = 'Assistência e tecnologia';

-- Aulas
INSERT INTO profissoes (categoria_id, nome, slug)
SELECT id, 'Professor(a) de reforço escolar', 'professor-reforco' FROM categorias WHERE nome = 'Aulas';
INSERT INTO profissoes (categoria_id, nome, slug)
SELECT id, 'Professor(a) de idiomas', 'professor-idiomas' FROM categorias WHERE nome = 'Aulas';
INSERT INTO profissoes (categoria_id, nome, slug)
SELECT id, 'Professor(a) de música', 'professor-musica' FROM categorias WHERE nome = 'Aulas';

-- Festas e eventos
INSERT INTO profissoes (categoria_id, nome, slug)
SELECT id, 'Fotógrafo(a)', 'fotografo' FROM categorias WHERE nome = 'Festas e eventos';
INSERT INTO profissoes (categoria_id, nome, slug)
SELECT id, 'Confeiteiro(a)', 'confeiteiro' FROM categorias WHERE nome = 'Festas e eventos';
INSERT INTO profissoes (categoria_id, nome, slug)
SELECT id, 'Salgadeiro(a)', 'salgadeiro' FROM categorias WHERE nome = 'Festas e eventos';
INSERT INTO profissoes (categoria_id, nome, slug)
SELECT id, 'Garçom/Garçonete', 'garcom' FROM categorias WHERE nome = 'Festas e eventos';


-- ============================================================
-- Conferência do seed
-- ============================================================
SELECT c.nome AS categoria, p.nome AS profissao, p.slug
FROM profissoes p
JOIN categorias c ON c.id = p.categoria_id
ORDER BY c.id, p.nome;
