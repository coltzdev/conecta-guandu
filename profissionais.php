<?php

require_once 'includes/conexao.php';

$busca = trim($_GET['busca'] ?? '');

$profissaoSelecionada = trim($_GET['profissao'] ?? '');

$bairroSelecionado = trim($_GET['bairro'] ?? '');


$consultaProfissoes = $conexao->query(
    'SELECT nome, slug
     FROM profissoes
     ORDER BY nome'
);

$profissoes = $consultaProfissoes->fetchAll();


$consultaBairros = $conexao->query(
    "SELECT DISTINCT bairro
     FROM profissionais
     WHERE status_publicacao = 1
       AND bairro IS NOT NULL
       AND bairro <> ''
     ORDER BY bairro"
);

$bairros = $consultaBairros->fetchAll(PDO::FETCH_COLUMN);


$sql = "
    SELECT
        p.id,
        p.nome,
        p.bairro,
        p.cidade,
        p.descricao,
        COALESCE(pr.nome, p.profissao_sugerida) AS profissao,
        c.nome AS categoria_nome,
        c.icone
    FROM profissionais p
    LEFT JOIN profissoes pr
        ON pr.id = p.profissao_id
    LEFT JOIN categorias c
        ON c.id = pr.categoria_id
    WHERE p.status_publicacao = 1
";

$parametros = [];


if ($profissaoSelecionada !== '') {

    $sql .= "
        AND pr.slug = :profissao
    ";

    $parametros['profissao'] = $profissaoSelecionada;
}


if ($bairroSelecionado !== '') {

    $sql .= "
        AND p.bairro = :bairro
    ";

    $parametros['bairro'] = $bairroSelecionado;
}


if ($busca !== '') {

    $sql .= "
        AND (
            p.nome LIKE :busca_nome
            OR pr.nome LIKE :busca_profissao
            OR p.profissao_sugerida LIKE :busca_sugerida
            OR p.descricao LIKE :busca_descricao
            OR EXISTS (
                SELECT 1
                FROM servicos_oferecidos so
                WHERE so.profissional_id = p.id
                  AND so.descricao LIKE :busca_servico
            )
        )
    ";

    $termoBusca = '%' . $busca . '%';

    $parametros['busca_nome'] = $termoBusca;
    $parametros['busca_profissao'] = $termoBusca;
    $parametros['busca_sugerida'] = $termoBusca;
    $parametros['busca_descricao'] = $termoBusca;
    $parametros['busca_servico'] = $termoBusca;
}


$sql .= "
    ORDER BY p.id
";


$consultaProfissionais = $conexao->prepare($sql);
$consultaProfissionais->execute($parametros);

$profissionaisFiltrados = $consultaProfissionais->fetchAll();

?>

<!DOCTYPE html>

<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="Veja a lista de profissionais autônomos de Baixo Guandu – ES. Filtre por profissão, bairro ou busque pelo serviço que você precisa.">

    <title>Profissionais | Conecta Guandu</title>

    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="assets/icons/bootstrap-icons.css">

    <link rel="stylesheet" href="assets/css/style.css?v=<?= filemtime(__DIR__ . '/assets/css/style.css') ?>">

</head>

<body>

    <?php require_once 'includes/navbar.php'; ?>

    <main class="pagina-profissionais" id="conteudo-principal">

        <header class="profissionais-apresentacao">

            <div class="container">

                <span class="profissionais-localizacao">
                    <i class="bi bi-geo-alt" aria-hidden="true"></i>
                    Baixo Guandu — ES
                </span>

                <h1>
                    Profissionais da cidade
                </h1>

                <p>
                    Busque por nome, profissão ou serviço e consulte as
                    informações de cada profissional.
                </p>

            </div>

        </header>

        <section class="profissionais-conteudo">

            <div class="container">

                <form class="filtros-profissionais" method="get">

                    <div class="row g-3 align-items-end">

                        <div class="col-lg-5">

                            <label for="busca" class="form-label">
                                O que você procura?
                            </label>

                            <div class="campo-busca-profissionais">

                                <i class="bi bi-search" aria-hidden="true"></i>

                                <input
                                    type="search"
                                    class="form-control"
                                    id="busca"
                                    name="busca"
                                    value="<?= htmlspecialchars($busca) ?>"
                                    placeholder="Nome, profissão ou serviço"
                                >

                            </div>

                        </div>

                        <div class="col-md-6 col-lg-3">

                            <label for="profissao" class="form-label">
                                Profissão
                            </label>

                            <select
                                class="form-select"
                                id="profissao"
                                name="profissao"
                            >

                                <option value="">
                                    Todas as profissões
                                </option>

                                <?php foreach ($profissoes as $profissao): ?>

                                    <option
                                        value="<?= htmlspecialchars($profissao['slug']) ?>"
                                        <?= $profissaoSelecionada === $profissao['slug'] ? 'selected' : '' ?>
                                    >
                                        <?= htmlspecialchars($profissao['nome']) ?>
                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>

                        <div class="col-md-6 col-lg-2">

                            <label for="bairro" class="form-label">
                                Bairro
                            </label>

                            <select
                                class="form-select"
                                id="bairro"
                                name="bairro"
                            >

                                <option value="">
                                    Todos os bairros
                                </option>

                                <?php foreach ($bairros as $bairro): ?>

                                    <option
                                        value="<?= htmlspecialchars($bairro) ?>"
                                        <?= $bairroSelecionado === $bairro ? 'selected' : '' ?>
                                    >
                                        <?= htmlspecialchars($bairro) ?>
                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>

                        <div class="col-lg-2">

                            <div class="filtros-acoes">

                                <button
                                    class="btn btn-busca"
                                    type="submit"
                                >
                                    Filtrar
                                </button>

                                <a
                                    class="btn btn-limpar-filtros"
                                    href="profissionais.php"
                                >
                                    <i class="bi bi-x-lg" aria-hidden="true"></i>
                                    Limpar
                                </a>

                            </div>

                        </div>

                    </div>

                </form>

                <section class="lista-profissionais">

                    <div class="resultado-profissionais">

                        <p class="resultado-contagem">

                            <strong>
                                <?= count($profissionaisFiltrados) ?>
                            </strong>

                            <?= count($profissionaisFiltrados) === 1 ? 'profissional encontrado' : 'profissionais encontrados' ?>

                        </p>

                    </div>

                    <?php if (count($profissionaisFiltrados) > 0): ?>

                        <div class="row g-3">

                            <?php foreach ($profissionaisFiltrados as $profissional): ?>

                                <div class="col-md-6">

                                    <article class="profissional-card">

                                        <div class="profissional-card-topo">

                                            <span class="profissional-icone">
                                                <i
                                                    class="bi <?= htmlspecialchars($profissional['icone'] ?? '') ?>"
                                                    aria-hidden="true"
                                                ></i>
                                            </span>

                                            <span class="profissional-categoria">
                                                <?= htmlspecialchars($profissional['categoria_nome'] ?? '') ?>
                                            </span>

                                        </div>

                                        <div class="profissional-card-conteudo">

                                            <h2>
                                                <?= htmlspecialchars($profissional['nome']) ?>
                                            </h2>

                                            <p class="profissional-profissao">
                                                <?= htmlspecialchars($profissional['profissao'] ?? '') ?>
                                            </p>

                                            <p class="profissional-bairro">

                                                <i
                                                    class="bi bi-geo-alt"
                                                    aria-hidden="true"
                                                ></i>

                                                <?= htmlspecialchars($profissional['bairro'] ?? '') ?>,
                                                <?= htmlspecialchars($profissional['cidade'] ?? '') ?>

                                            </p>

                                            <p class="profissional-descricao">
                                                <?= htmlspecialchars($profissional['descricao'] ?? '') ?>
                                            </p>

                                            <a
                                                href="profissional.php?id=<?= (int) $profissional['id'] ?>"
                                                class="btn-ver-perfil"
                                            >
                                                Ver perfil
                                            </a>

                                        </div>

                                    </article>

                                </div>

                            <?php endforeach; ?>

                        </div>

                    <?php else: ?>

                        <div class="sem-resultados">

                            <h2>
                                Nenhum profissional encontrado
                            </h2>

                            <p>
                                Tente alterar os filtros ou fazer outra busca.
                            </p>

                        </div>

                    <?php endif; ?>

                </section>

            </div>

        </section>

    </main>

    <?php require_once 'includes/footer.php'; ?>

    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="assets/js/script.js"></script>

</body>

</html>