    <footer class="site-footer">
        <div class="container py-5">
            <div class="row gy-4">
                <div class="col-12 col-md-4">
                    <h2 class="h5">SolvR</h2>
                    <p class="mb-0">Sites internet et applications sur mesure pour les PME, commerçants et artisans.</p>
                </div>

                <div class="col-12 col-md-4">
                    <h2 class="h6">Contact</h2>
                    <address class="mb-0">
                        <a href="mailto:contact@solvr.fr">contact@solvr.fr</a><br>
                        <a href="tel:+33670104428">06 70 10 44 28</a>
                    </address>
                </div>

                <div class="col-12 col-md-4">
                    <h2 class="h6">Zone d'intervention</h2>
                    <p class="mb-0">Nice et les Alpes-Maritimes.<br>Toute la France à distance.</p>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex flex-column flex-md-row justify-content-between gap-2">
                <p class="mb-0">&copy; <?= date('Y') ?> SolvR — EI</p>
                                <nav aria-label="Liens légaux">
                    <ul class="list-inline mb-0">
                        <?php foreach (['mentions-legales', 'confidentialite'] as $key): ?>
                            <li class="list-inline-item">
                                <a href="<?= e($pages[$key]['path']) ?>"><?= e($pages[$key]['label']) ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </footer>

    <script src="/assets/vendor/bootstrap/bootstrap.bundle.min.js" defer></script>
</body>
</html>