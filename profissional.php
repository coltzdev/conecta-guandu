<?php

require_once 'includes/conexao.php';

$id = filter_input(
    INPUT_GET,
    'id',
    FILTER_VALIDATE_INT,
    [
        'options' => [
            'min_range' => 1
        ]
    ]
);

$profissional = null;

if ($id !== false && $id !== null) {

    $consultaProfissional = $conexao->prepare(
        "
        SELECT
            p.nome,
            p.foto,
            p.bairro,
            p.cidade,
            p.experiencia,
            p.descricao,
            p.area_atendimento,
            p.telefone,
            p.whatsapp,
            p.instagram,
            COALESCE(pr.nome, p.profissao_sugerida) AS profissao
        FROM profissionais p
        LEFT JOIN profissoes pr
            ON pr.id = p.profissao_id
        WHERE p.id = :id
          AND p.status_publicacao = 1
        LIMIT 1
        "
    );

    $consultaProfissional->execute([
        'id' => $id
    ]);

    $profissional = $consultaProfissional->fetch() ?: null;


    if ($profissional) {

        $consultaFormas = $conexao->prepare(
            "
            SELECT descricao
            FROM formas_atendimento
            WHERE profissional_id = :profissional_id
            ORDER BY ordem_exibicao, id
            "
        );

        $consultaFormas->execute([
            'profissional_id' => $id
        ]);

        $profissional['formas_atendimento'] =
            $consultaFormas->fetchAll(PDO::FETCH_COLUMN);


        $consultaServicos = $conexao->prepare(
            "
            SELECT descricao
            FROM servicos_oferecidos
            WHERE profissional_id = :profissional_id
            ORDER BY ordem_exibicao, id
            "
        );

        $consultaServicos->execute([
            'profissional_id' => $id
        ]);

        $profissional['principais_servicos'] =
            $consultaServicos->fetchAll(PDO::FETCH_COLUMN);


        $consultaHorarios = $conexao->prepare(
            "
            SELECT
                periodo_dia,
                horario
            FROM horarios_atendimento
            WHERE profissional_id = :profissional_id
            ORDER BY ordem_exibicao, id
            "
        );

        $consultaHorarios->execute([
            'profissional_id' => $id
        ]);

        $profissional['horarios'] =
            $consultaHorarios->fetchAll();


        $consultaPortfolio = $conexao->prepare(
            "
            SELECT caminho_imagem
            FROM portfolio
            WHERE profissional_id = :profissional_id
            ORDER BY ordem_exibicao, id
            LIMIT 8
            "
        );

        $consultaPortfolio->execute([
            'profissional_id' => $id
        ]);

        $profissional['portfolio'] =
            $consultaPortfolio->fetchAll(PDO::FETCH_COLUMN);
    }
}


if ($profissional === null) {
    http_response_code(404);
}


if ($profissional) {

    $metaDescription = sprintf(
        '%s atua como %s no bairro %s, em Baixo Guandu – ES. Conheça seus serviços, informações profissionais e formas de contato.',
        $profissional['nome'],
        $profissional['profissao'],
        $profissional['bairro']
    );

} else {

    $metaDescription =
        'Profissional não encontrado no Conecta Guandu. Veja a lista completa de profissionais de Baixo Guandu – ES.';
}


$portfolioInicial = [];
$portfolioExtra = [];

if ($profissional && !empty($profissional['portfolio'])) {

    $portfolioInicial = array_slice(
        $profissional['portfolio'],
        0,
        3
    );

    $portfolioExtra = array_slice(
        $profissional['portfolio'],
        3
    );
}

?>

<!DOCTYPE html>

<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="description"
        content="<?= htmlspecialchars($metaDescription) ?>"
    >

    <title>
        <?= $profissional
            ? htmlspecialchars($profissional['nome']) . ' | Conecta Guandu'
            : 'Profissional não encontrado | Conecta Guandu'
        ?>
    </title>

    <link
        rel="stylesheet"
        href="assets/bootstrap/css/bootstrap.min.css"
    >

    <link
        rel="stylesheet"
        href="assets/icons/bootstrap-icons.css"
    >

    <link
        rel="stylesheet"
        href="assets/css/style.css?v=<?= filemtime(__DIR__ . '/assets/css/style.css') ?>"
    >

</head>

<body>

    <?php require_once 'includes/navbar.php'; ?>

    <main class="pagina-perfil" id="conteudo-principal">

        <div class="container">

            <?php if ($profissional): ?>

                <article class="perfil-profissional">

                    <header class="perfil-topo">

                        <div class="perfil-foto">

                            <?php if (!empty($profissional['foto'])): ?>

                                <img
                                    src="assets/img/profissionais/<?= htmlspecialchars($profissional['foto']) ?>"
                                    alt="Foto de <?= htmlspecialchars($profissional['nome']) ?>"
                                >

                            <?php else: ?>

                                <div
                                    class="perfil-avatar-padrao"
                                    aria-hidden="true"
                                >
                                    <i class="bi bi-person"></i>
                                </div>

                            <?php endif; ?>

                        </div>


                        <div class="perfil-identidade">

                            <h1>
                                <?= htmlspecialchars($profissional['nome']) ?>
                            </h1>

                            <p class="perfil-profissao">
                                <?= htmlspecialchars($profissional['profissao']) ?>
                            </p>


                            <div class="perfil-meta">

                                <span>

                                    <i
                                        class="bi bi-geo-alt"
                                        aria-hidden="true"
                                    ></i>

                                    <?= htmlspecialchars($profissional['bairro']) ?>,
                                    <?= htmlspecialchars($profissional['cidade']) ?> — ES

                                </span>


                                <?php if (!empty($profissional['experiencia'])): ?>

                                    <span>

                                        <i
                                            class="bi bi-briefcase"
                                            aria-hidden="true"
                                        ></i>

                                        <?= htmlspecialchars($profissional['experiencia']) ?>
                                        de experiência

                                    </span>

                                <?php endif; ?>

                            </div>


                            <?php if (!empty($profissional['formas_atendimento'])): ?>

                                <section
                                    class="perfil-formas-atendimento"
                                    aria-labelledby="titulo-formas-atendimento"
                                >

                                    <h2 id="titulo-formas-atendimento">
                                        Formas de atendimento
                                    </h2>

                                    <div>

                                        <?php foreach ($profissional['formas_atendimento'] as $forma): ?>

                                            <span>

                                                <i
                                                    class="bi bi-check2"
                                                    aria-hidden="true"
                                                ></i>

                                                <?= htmlspecialchars($forma) ?>

                                            </span>

                                        <?php endforeach; ?>

                                    </div>

                                </section>

                            <?php endif; ?>

                        </div>


                        <?php if (
                            !empty($profissional['whatsapp']) ||
                            !empty($profissional['instagram']) ||
                            !empty($profissional['telefone'])
                        ): ?>

                            <aside
                                class="perfil-contato"
                                aria-labelledby="titulo-contato"
                            >

                                <span class="perfil-secao-identificacao">
                                    Contato e atendimento
                                </span>

                                <h2 id="titulo-contato">
                                    Fale com
                                    <?= htmlspecialchars(
                                        explode(' ', trim($profissional['nome']))[0]
                                    ) ?>
                                </h2>

                                <p>
                                    Consulte a disponibilidade e combine os detalhes diretamente.
                                </p>


                                <div class="perfil-contato-acoes">

                                    <?php if (!empty($profissional['whatsapp'])): ?>

                                        <a
                                            class="perfil-contato-botao perfil-contato-whatsapp"
                                            href="https://wa.me/<?= htmlspecialchars($profissional['whatsapp']) ?>"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                        >

                                            <i
                                                class="bi bi-whatsapp"
                                                aria-hidden="true"
                                            ></i>

                                            <span>
                                                Conversar pelo WhatsApp
                                            </span>

                                        </a>

                                    <?php endif; ?>


                                    <?php if (!empty($profissional['instagram'])): ?>

                                        <a
                                            class="perfil-contato-botao perfil-contato-instagram"
                                            href="<?= htmlspecialchars($profissional['instagram']) ?>"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                        >

                                            <i
                                                class="bi bi-instagram"
                                                aria-hidden="true"
                                            ></i>

                                            <span>
                                                Ver perfil no Instagram
                                            </span>

                                        </a>

                                    <?php endif; ?>

                                </div>


                                <?php if (!empty($profissional['telefone'])): ?>

                                    <a
                                        class="perfil-telefone"
                                        href="tel:<?= preg_replace(
                                            '/\D/',
                                            '',
                                            $profissional['telefone']
                                        ) ?>"
                                    >

                                        <i
                                            class="bi bi-telephone"
                                            aria-hidden="true"
                                        ></i>

                                        <?= htmlspecialchars($profissional['telefone']) ?>

                                    </a>

                                <?php endif; ?>

                            </aside>

                        <?php endif; ?>

                    </header>


                    <div class="perfil-conteudo">

                        <div class="perfil-conteudo-principal">

                            <?php if (!empty($profissional['descricao'])): ?>

                                <section class="perfil-sobre">

                                    <span class="perfil-secao-identificacao">
                                        Apresentação
                                    </span>

                                    <h2>
                                        Sobre o profissional
                                    </h2>

                                    <p>
                                        <?= htmlspecialchars($profissional['descricao']) ?>
                                    </p>

                                </section>

                            <?php endif; ?>


                            <?php if (!empty($profissional['principais_servicos'])): ?>

                                <section class="perfil-servicos">

                                    <span class="perfil-secao-identificacao">
                                        Especialidades
                                    </span>

                                    <h2>
                                        Principais serviços
                                    </h2>


                                    <div class="perfil-servicos-lista">

                                        <?php foreach (
                                            array_slice(
                                                $profissional['principais_servicos'],
                                                0,
                                                5
                                            ) as $servico
                                        ): ?>

                                            <div class="perfil-servico">

                                                <i
                                                    class="bi bi-check-circle"
                                                    aria-hidden="true"
                                                ></i>

                                                <span>
                                                    <?= htmlspecialchars($servico) ?>
                                                </span>

                                            </div>

                                        <?php endforeach; ?>

                                    </div>


                                    <p class="perfil-servicos-observacao">
                                        Consulte o profissional sobre outros serviços.
                                    </p>

                                </section>

                            <?php endif; ?>

                        </div>


                        <aside
                            class="perfil-informacoes-praticas"
                            aria-label="Informações práticas"
                        >

                            <?php if (!empty($profissional['area_atendimento'])): ?>

                                <section class="perfil-informacao-pratica">

                                    <i
                                        class="bi bi-map"
                                        aria-hidden="true"
                                    ></i>

                                    <div>

                                        <h2>
                                            Área de atendimento
                                        </h2>

                                        <p>
                                            <?= htmlspecialchars($profissional['area_atendimento']) ?>
                                        </p>

                                    </div>

                                </section>

                            <?php endif; ?>


                            <?php if (!empty($profissional['horarios'])): ?>

                                <section class="perfil-informacao-pratica">

                                    <i
                                        class="bi bi-clock"
                                        aria-hidden="true"
                                    ></i>

                                    <div>

                                        <h2>
                                            Horários de atendimento
                                        </h2>

                                        <dl class="perfil-horarios">

                                            <?php foreach (
                                                $profissional['horarios'] as $horarioAtendimento
                                            ): ?>

                                                <div>

                                                    <dt>
                                                        <?= htmlspecialchars(
                                                            $horarioAtendimento['periodo_dia']
                                                        ) ?>
                                                    </dt>

                                                    <dd>
                                                        <?= htmlspecialchars(
                                                            $horarioAtendimento['horario']
                                                        ) ?>
                                                    </dd>

                                                </div>

                                            <?php endforeach; ?>

                                        </dl>

                                    </div>

                                </section>

                            <?php endif; ?>


                            <p class="perfil-aviso">

                                <i
                                    class="bi bi-chat-square-text"
                                    aria-hidden="true"
                                ></i>

                                <span>
                                    Valores, disponibilidade e detalhes do serviço são combinados diretamente com o profissional.
                                </span>

                            </p>

                        </aside>

                    </div>


                    <?php if (!empty($portfolioInicial)): ?>

                        <section class="perfil-portfolio">

                            <div class="perfil-portfolio-cabecalho">

                                <div>

                                    <span class="perfil-secao-identificacao">
                                        Portfólio
                                    </span>

                                    <h2>
                                        Trabalhos realizados
                                    </h2>

                                </div>

                            </div>


                            <div class="perfil-portfolio-grade">

                                <?php foreach ($portfolioInicial as $imagem): ?>

                                    <figure>

                                        <img
                                            src="assets/img/profissionais/<?= htmlspecialchars($imagem) ?>"
                                            alt="Trabalho realizado por <?= htmlspecialchars($profissional['nome']) ?>"
                                            loading="lazy"
                                        >

                                    </figure>

                                <?php endforeach; ?>

                            </div>


                            <?php if (!empty($portfolioExtra)): ?>

                                <details class="perfil-portfolio-extra">

                                    <summary class="perfil-portfolio-abrir">

                                        Ver mais trabalhos

                                        <i
                                            class="bi bi-chevron-down"
                                            aria-hidden="true"
                                        ></i>

                                    </summary>


                                    <div class="perfil-portfolio-grade perfil-portfolio-grade-extra">

                                        <?php foreach ($portfolioExtra as $imagem): ?>

                                            <figure>

                                                <img
                                                    src="assets/img/profissionais/<?= htmlspecialchars($imagem) ?>"
                                                    alt="Trabalho realizado por <?= htmlspecialchars($profissional['nome']) ?>"
                                                    loading="lazy"
                                                >

                                            </figure>

                                        <?php endforeach; ?>

                                    </div>


                                    <button
                                        class="perfil-portfolio-fechar"
                                        type="button"
                                        onclick="this.closest('details').removeAttribute('open')"
                                    >

                                        Mostrar menos

                                        <i
                                            class="bi bi-chevron-up"
                                            aria-hidden="true"
                                        ></i>

                                    </button>

                                </details>

                            <?php endif; ?>

                        </section>

                    <?php endif; ?>

                </article>


            <?php else: ?>

                <div class="sem-resultados">

                    <h1>
                        Profissional não encontrado
                    </h1>

                    <p>
                        O profissional informado não existe.
                    </p>

                    <a
                        class="btn-ver-profissionais"
                        href="profissionais.php"
                    >
                        Ver profissionais
                    </a>

                </div>

            <?php endif; ?>

        </div>

    </main>


    <?php require_once 'includes/footer.php'; ?>


    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="assets/js/script.js"></script>

</body>

</html>