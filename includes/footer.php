<?php $contact = config()['contact']; ?>

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
                    <a href="mailto:<?= e($contact['email']) ?>"><?= e($contact['email']) ?></a><br>
                    <a href="tel:<?= e($contact['phone_link']) ?>"><?= e($contact['phone']) ?></a>
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

<!-- Bootstrap sans Popper (inutile : aucun menu déroulant ni infobulle) ; sert au menu burger -->
<script src="<?= asset('/assets/vendor/bootstrap/bootstrap.min.js') ?>" defer></script>
<script src="<?= asset('/assets/js/main.js') ?>" defer></script>
<script src="<?= asset('/assets/js/animations.js') ?>" defer></script>
</body>

</html>