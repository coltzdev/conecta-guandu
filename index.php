<?php

require_once 'includes/conexao.php';

$consultaDestaques = $conexao->query(
    "
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
    ORDER BY p.id
    LIMIT 3
    "
);

$profissionaisDestaque = $consultaDestaques->fetchAll();

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Encontre profissionais autônomos em Baixo Guandu – ES. Busque por categoria, consulte os perfis e veja as formas de contato disponíveis.">

    <title>Conecta Guandu</title>

    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css?v=<?= filemtime(__DIR__ . '/assets/css/style.css') ?>">
</head>

<body>

    <?php require_once 'includes/navbar.php'; ?>

    <main id="conteudo-principal">

        <section class="inicio-apresentacao">
            <div class="container">

                <div class="inicio-conteudo">

                    <div class="inicio-local">
                        <i class="bi bi-geo-alt" aria-hidden="true"></i>
                        Baixo Guandu — ES
                    </div>

                    <h1>
                        Encontre o profissional certo para o que você precisa
                    </h1>

                    <p class="inicio-texto">
                        Consulte profissionais e serviços disponíveis em
                        Baixo Guandu de forma simples e direta.
                    </p>

                    <form
                        class="formulario-busca"
                        action="profissionais.php"
                        method="get"
                    >

                        <label for="busca" class="busca-titulo">
                            Qual serviço você procura?
                        </label>

                        <div class="busca-principal">

                            <div class="busca-campo">

                                <i class="bi bi-search" aria-hidden="true"></i>

                                <input
                                    type="search"
                                    id="busca"
                                    name="busca"
                                    placeholder="O que você está procurando?"
                                >

                            </div>

                            <button class="btn btn-busca" type="submit">
                                Buscar profissional
                            </button>

                        </div>

                        <p class="busca-exemplos">
                            Exemplos:
                            <a href="profissionais.php?profissao=eletricista">
                                eletricista
                            </a>,
                            <a href="profissionais.php?profissao=manicure-pedicure">
                                manicure
                            </a>
                            ou
                            <a href="profissionais.php?profissao=pedreiro">
                                pedreiro
                            </a>.
                        </p>

                    </form>

                </div>

            </div>
        </section>


        <section class="secao-categorias">
            <div class="container">

                <div class="categorias-cabecalho">

                    <div>

                        <span class="secao-identificacao">
                            Serviços
                        </span>

                        <h2>
                            Encontre por categoria
                        </h2>

                        <p>
                            Escolha uma categoria para encontrar profissionais autônomos que atendem em Baixo Guandu.
                        </p>

                    </div>

                </div>


                <div class="categorias-lista">

                    <div class="categoria-menu">

                        <button class="categoria-menu-botao" type="button" aria-expanded="false">

                            <span class="categoria-icone">
                                <i class="bi bi-house-door" aria-hidden="true"></i>
                            </span>

                            <span class="categoria-nome">
                                Serviços domésticos
                            </span>

                            <span class="categoria-indicacao">
                                <i class="bi bi-chevron-down" aria-hidden="true"></i>
                            </span>

                        </button>

                        <div class="categoria-submenu">

                            <a href="profissionais.php?profissao=faxineiro">
                                Faxineiro(a)
                            </a>

                            <a href="profissionais.php?profissao=baba">
                                Babá
                            </a>

                            <a href="profissionais.php?profissao=cuidador">
                                Cuidador(a) de pessoas
                            </a>

                        </div>

                    </div>


                    <div class="categoria-menu">

                        <button class="categoria-menu-botao" type="button" aria-expanded="false">

                            <span class="categoria-icone">
                                <i class="bi bi-tools" aria-hidden="true"></i>
                            </span>

                            <span class="categoria-nome">
                                Reformas e reparos
                            </span>

                            <span class="categoria-indicacao">
                                <i class="bi bi-chevron-down" aria-hidden="true"></i>
                            </span>

                        </button>

                        <div class="categoria-submenu">

                            <a href="profissionais.php?profissao=eletricista">
                                Eletricista
                            </a>

                            <a href="profissionais.php?profissao=encanador">
                                Encanador
                            </a>

                            <a href="profissionais.php?profissao=pedreiro">
                                Pedreiro
                            </a>

                            <a href="profissionais.php?profissao=pintor">
                                Pintor
                            </a>

                            <a href="profissionais.php?profissao=montador-moveis">
                                Montador(a) de móveis
                            </a>

                            <a href="profissionais.php?profissao=arquiteto">
                                Arquiteto(a)
                            </a>

                            <a href="profissionais.php?profissao=engenheiro">
                                Engenheiro(a)
                            </a>

                        </div>

                    </div>


                    <div class="categoria-menu">

                        <button class="categoria-menu-botao" type="button" aria-expanded="false">

                            <span class="categoria-icone">
                                <i class="bi bi-scissors" aria-hidden="true"></i>
                            </span>

                            <span class="categoria-nome">
                                Beleza e moda
                            </span>

                            <span class="categoria-indicacao">
                                <i class="bi bi-chevron-down" aria-hidden="true"></i>
                            </span>

                        </button>

                        <div class="categoria-submenu">

                            <a href="profissionais.php?profissao=costureiro">
                                Costureiro(a)
                            </a>

                            <a href="profissionais.php?profissao=barbeiro">
                                Barbeiro(a)
                            </a>

                            <a href="profissionais.php?profissao=maquiador">
                                Maquiador(a)
                            </a>

                            <a href="profissionais.php?profissao=manicure-pedicure">
                                Manicure/Pedicure
                            </a>

                        </div>

                    </div>


                    <div class="categoria-menu">

                        <button class="categoria-menu-botao" type="button" aria-expanded="false">

                            <span class="categoria-icone">
                                <i class="bi bi-car-front" aria-hidden="true"></i>
                            </span>

                            <span class="categoria-nome">
                                Automotivo
                            </span>

                            <span class="categoria-indicacao">
                                <i class="bi bi-chevron-down" aria-hidden="true"></i>
                            </span>

                        </button>

                        <div class="categoria-submenu">

                            <a href="profissionais.php?profissao=lavador-veiculos">
                                Lavador(a) de veículos
                            </a>

                            <a href="profissionais.php?profissao=pintor-automotivo">
                                Pintor(a) automotivo
                            </a>

                        </div>

                    </div>


                    <div class="categoria-menu">

                        <button class="categoria-menu-botao" type="button" aria-expanded="false">

                            <span class="categoria-icone">
                                <i class="bi bi-laptop" aria-hidden="true"></i>
                            </span>

                            <span class="categoria-nome">
                                Assistência e tecnologia
                            </span>

                            <span class="categoria-indicacao">
                                <i class="bi bi-chevron-down" aria-hidden="true"></i>
                            </span>

                        </button>

                        <div class="categoria-submenu">

                            <a href="profissionais.php?profissao=tecnico-informatica">
                                Técnico(a) de informática
                            </a>

                            <a href="profissionais.php?profissao=tecnico-celulares">
                                Técnico(a) de celulares
                            </a>

                        </div>

                    </div>


                    <div class="categoria-menu">

                        <button class="categoria-menu-botao" type="button" aria-expanded="false">

                            <span class="categoria-icone">
                                <i class="bi bi-book" aria-hidden="true"></i>
                            </span>

                            <span class="categoria-nome">
                                Aulas
                            </span>

                            <span class="categoria-indicacao">
                                <i class="bi bi-chevron-down" aria-hidden="true"></i>
                            </span>

                        </button>

                        <div class="categoria-submenu">

                            <a href="profissionais.php?profissao=professor-reforco">
                                Professor(a) de reforço escolar
                            </a>

                            <a href="profissionais.php?profissao=professor-idiomas">
                                Professor(a) de idiomas
                            </a>

                            <a href="profissionais.php?profissao=professor-musica">
                                Professor(a) de música
                            </a>

                        </div>

                    </div>


                    <div class="categoria-menu">

                        <button class="categoria-menu-botao" type="button" aria-expanded="false">

                            <span class="categoria-icone">
                                <i class="bi bi-balloon" aria-hidden="true"></i>
                            </span>

                            <span class="categoria-nome">
                                Festas e eventos
                            </span>

                            <span class="categoria-indicacao">
                                <i class="bi bi-chevron-down" aria-hidden="true"></i>
                            </span>

                        </button>

                        <div class="categoria-submenu">

                            <a href="profissionais.php?profissao=fotografo">
                                Fotógrafo(a)
                            </a>

                            <a href="profissionais.php?profissao=confeiteiro">
                                Confeiteiro(a)
                            </a>

                            <a href="profissionais.php?profissao=salgadeiro">
                                Salgadeiro(a)
                            </a>

                            <a href="profissionais.php?profissao=garcom">
                                Garçom/Garçonete
                            </a>

                        </div>

                    </div>

                </div>

            </div>
        </section>


        <section class="secao-como-funciona">
            <div class="container">

                <div class="secao-cabecalho-central">

                    <span class="secao-identificacao">
                        Como funciona
                    </span>

                    <h2>
                        Encontre um profissional em poucos passos
                    </h2>

                    <p>
                        Use a plataforma para localizar serviços disponíveis
                        em Baixo Guandu e entrar em contato diretamente.
                    </p>

                </div>


                <div class="row g-4">

                    <div class="col-md-4">

                        <article class="passo-card">

                            <div class="passo-numero">
                                1
                            </div>

                            <div class="passo-icone">
                                <i class="bi bi-search" aria-hidden="true"></i>
                            </div>

                            <h3>
                                Busque o serviço
                            </h3>

                            <p>
                                Pesquise pelo nome do profissional,
                                profissão ou tipo de serviço que precisa.
                            </p>

                        </article>

                    </div>


                    <div class="col-md-4">

                        <article class="passo-card">

                            <div class="passo-numero">
                                2
                            </div>

                            <div class="passo-icone">
                                <i class="bi bi-person-vcard" aria-hidden="true"></i>
                            </div>

                            <h3>
                                Consulte o perfil
                            </h3>

                            <p>
                                Veja informações sobre o profissional,
                                serviço prestado e área de atendimento.
                            </p>

                        </article>

                    </div>


                    <div class="col-md-4">

                        <article class="passo-card">

                            <div class="passo-numero">
                                3
                            </div>

                            <div class="passo-icone">
                                <i class="bi bi-chat-dots" aria-hidden="true"></i>
                            </div>

                            <h3>
                                Entre em contato
                            </h3>

                            <p>
                                Utilize os meios de contato disponíveis
                                no perfil para falar diretamente com ele.
                            </p>

                        </article>

                    </div>

                </div>

            </div>
        </section>


        <section class="secao-destaques">
            <div class="container">

                <div class="destaques-cabecalho">

                    <div class="destaques-titulo">

                        <span class="secao-identificacao">
                            Perto de você
                        </span>

                        <h2>
                            Alguns profissionais disponíveis
                        </h2>

                        <p class="destaques-introducao">
                            Conheça alguns dos profissionais presentes no
                            Conecta Guandu.
                        </p>

                    </div>

                </div>


                <div class="row g-3">

                    <?php foreach ($profissionaisDestaque as $profissional): ?>

                        <div class="col-md-6 col-lg-4">

                            <article class="destaque-profissional">

                                <div class="destaque-profissional-topo">

                                    <div class="profissional-icone">
                                        <i
                                            class="bi <?= htmlspecialchars($profissional['icone'] ?? '') ?>"
                                            aria-hidden="true"
                                        ></i>
                                    </div>

                                    <span class="destaque-categoria">
                                        <?= htmlspecialchars($profissional['categoria_nome'] ?? '') ?>
                                    </span>

                                </div>

                                <h3>
                                    <?= htmlspecialchars($profissional['nome']) ?>
                                </h3>

                                <p class="destaque-profissao">
                                    <?= htmlspecialchars($profissional['profissao'] ?? '') ?>
                                </p>

                                <p class="destaque-localizacao">
                                    <i class="bi bi-geo-alt" aria-hidden="true"></i>

                                    <?= htmlspecialchars($profissional['bairro'] ?? '') ?>,
                                    <?= htmlspecialchars($profissional['cidade'] ?? '') ?>
                                </p>

                                <p class="destaque-descricao">
                                    <?= htmlspecialchars($profissional['descricao'] ?? '') ?>
                                </p>

                                <a
                                    class="btn-ver-perfil"
                                    href="profissional.php?id=<?= (int) $profissional['id'] ?>"
                                >
                                    Ver perfil
                                </a>

                            </article>

                        </div>

                    <?php endforeach; ?>

                </div>


                <div class="destaques-acao">

                    <a
                        class="btn-ver-profissionais"
                        href="profissionais.php"
                    >
                        Ver todos os profissionais
                    </a>

                </div>

            </div>
        </section>

    </main>

    <?php require_once 'includes/footer.php'; ?>

    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>

</body>

</html>