<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Conheça o Conecta Guandu, projeto acadêmico e independente que conecta moradores de Baixo Guandu – ES a profissionais autônomos da cidade.">
    <title>Quem somos | Conecta Guandu</title>

    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css?v=<?= filemtime(__DIR__ . '/assets/css/style.css') ?>">
</head>
<body>
    <?php require_once 'includes/navbar.php'; ?>

    <main class="pagina-quem-somos" id="conteudo-principal">
        <section class="quem-somos-apresentacao">
            <div class="container">
                <div class="row g-5 align-items-start">
                    <div class="col-lg-5">
                        <div class="quem-somos-titulo">
                            <span class="secao-identificacao">Quem somos</span>

                            <h1>
                                Da nossa cidade,
                                <strong>
                                    para o nosso dia a dia.
                                </strong>
                            </h1>

                            <p class="quem-somos-localizacao">
                                <i class="bi bi-geo-alt" aria-hidden="true"></i>
                                Baixo Guandu — Espírito Santo
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="quem-somos-introducao">
                            <h2>Conexões locais, de um jeito simples.</h2>

                            <p>
                                O Conecta Guandu nasceu como um <strong>projeto acadêmico</strong>,
                                a partir da ideia de criar uma plataforma que facilite o encontro
                                entre moradores de Baixo Guandu e profissionais autônomos que atuam na cidade.
                            </p>

                            <p>
                                Aqui, você pode pesquisar pelo serviço que precisa, conhecer o perfil
                                dos profissionais e entrar em contato diretamente pelos meios disponibilizados.
                            </p>

                            <p>
                                A proposta é reunir essas informações de forma simples e organizada,
                                valorizando profissionais locais e facilitando a busca por serviços no dia a dia.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="quem-somos-pilares">
                    <article class="quem-somos-pilar">
                        <i class="bi bi-geo-alt" aria-hidden="true"></i>

                        <div>
                            <h2>Foco na cidade</h2>
                            <p>Profissionais e serviços voltados para Baixo Guandu.</p>
                        </div>
                    </article>

                    <article class="quem-somos-pilar">
                        <i class="bi bi-card-list" aria-hidden="true"></i>

                        <div>
                            <h2>Busca mais simples</h2>
                            <p>Informações organizadas para facilitar a procura por profissionais.</p>
                        </div>
                    </article>

                    <article class="quem-somos-pilar">
                        <i class="bi bi-chat-dots" aria-hidden="true"></i>

                        <div>
                            <h2>Contato direto</h2>
                            <p>Você fala diretamente com o profissional pelos meios disponíveis no perfil.</p>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <section class="quem-somos-independente">
            <div class="container">
                <div class="quem-somos-independente-conteudo">
                    <div class="quem-somos-independente-titulo">
                        <span class="secao-identificacao">Projeto independente</span>
                        <h2>Uma iniciativa acadêmica</h2>
                    </div>

                    <div class="quem-somos-independente-texto">
                        <p>
                            O Conecta Guandu é um <strong>projeto acadêmico e independente</strong>.
                            A plataforma não possui vínculo com a Prefeitura Municipal de Baixo Guandu,
                            com órgãos públicos ou com qualquer serviço oficial do município.
                        </p>

                        <p>
                            O Conecta Guandu atua como um meio de apresentação e contato. Valores,
                            disponibilidade, contratação e demais condições dos serviços são combinados
                            diretamente entre o usuário e o profissional.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="quem-somos-como-funciona">
            <div class="container">
                <div class="quem-somos-como-funciona-cabecalho">
                    <span class="secao-identificacao">Como funciona</span>
                    <h2>Do serviço que você procura ao contato com o profissional.</h2>
                </div>

                <div class="quem-somos-etapas">
                    <article class="quem-somos-etapa">
                        <span class="quem-somos-etapa-numero">01</span>
                        <i class="bi bi-search" aria-hidden="true"></i>
                        <h3>Encontre</h3>
                        <p>Pesquise pelo serviço ou profissão que precisa em Baixo Guandu.</p>
                    </article>

                    <article class="quem-somos-etapa">
                        <span class="quem-somos-etapa-numero">02</span>
                        <i class="bi bi-person" aria-hidden="true"></i>
                        <h3>Conheça</h3>
                        <p>Consulte informações, principais serviços, área de atendimento e trabalhos realizados.</p>
                    </article>

                    <article class="quem-somos-etapa">
                        <span class="quem-somos-etapa-numero">03</span>
                        <i class="bi bi-chat-dots" aria-hidden="true"></i>
                        <h3>Entre em contato</h3>
                        <p>Fale diretamente com o profissional pelos meios de contato disponíveis no perfil.</p>
                    </article>
                </div>
            </div>
        </section>
    </main>

    <?php require_once 'includes/footer.php'; ?>

    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
