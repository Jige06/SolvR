<?php
// Pages à afficher dans le menu principal
$navItems = array_filter($pages, fn(array $p): bool => $p['nav']);
?>

<body>
    <a class="visually-hidden-focusable skip-link" href="#contenu">Aller au contenu</a>

    <header class="site-header">
        <nav class="navbar navbar-expand-lg" aria-label="Navigation principale">
            <div class="container">
                <a class="navbar-brand" href="<?= e($pages['accueil']['path']) ?>">SolvR</a>

                <!-- Bascule clair / sombre : masqué tant que JavaScript ne l'a pas activé -->
                <button type="button" class="theme-toggle ms-auto ms-lg-3 order-lg-last"
                    data-theme-toggle aria-pressed="false" hidden>
                    <?= icon('moon', 'icon-moon') ?>
                    <?= icon('sun', 'icon-sun') ?>
                    <span class="visually-hidden">Mode sombre</span>
                </button>

                <button class="navbar-toggler ms-2" type="button"
                    data-bs-toggle="collapse" data-bs-target="#menu-principal"
                    aria-controls="menu-principal" aria-expanded="false"
                    aria-label="Ouvrir le menu">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="menu-principal">
                    <ul class="navbar-nav ms-auto mb-3 mb-lg-0 align-items-lg-center">

                        <!-- 1. Les liens du menu : un passage de boucle par page -->
                        <?php foreach ($navItems as $key => $item): ?>
                            <?php $isCurrent = ($key === $currentPage); ?>
                            <li class="nav-item">
                                <a class="nav-link<?= $isCurrent ? ' active' : '' ?>"
                                    href="<?= e($item['path']) ?>"
                                    <?= $isCurrent ? 'aria-current="page"' : '' ?>>
                                    <?= e($item['label']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>

                        <!-- 2. Le bouton Contact : APRÈS la boucle, affiché une seule fois -->
                        <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                            <a class="btn btn-primary" href="<?= e($pages['contact']['path']) ?>"
                                <?= $currentPage === 'contact' ? 'aria-current="page"' : '' ?>>
                                <?= e($pages['contact']['label']) ?>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
    </header>