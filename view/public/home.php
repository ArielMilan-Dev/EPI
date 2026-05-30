<?php
$pageTitle = "EPI Yamoussoukro — École Polytechnique Internationale";
require_once __DIR__ . '/../layout/public_header.php';
?>

<!-- ═══════════ HERO ═══════════ -->
<main id="main-content">
<section class="hero" aria-label="Section principale">
    <div class="hero-grid" aria-hidden="true"></div>
    <div class="hero-orbs" aria-hidden="true">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
    </div>

    <div class="hero-content container">
        <div class="hero-badge" role="text">
            <i class="fas fa-star" aria-hidden="true"></i>
            BTS Professionnel · Yamoussoukro, Côte d'Ivoire
        </div>

        <h1 class="hero-title">
            Votre avenir<br>
            <span class="highlight">commence à l'EPI</span>
        </h1>

        <p class="hero-sub">
            L'École Polytechnique Internationale de Yamoussoukro vous ouvre les portes 
            de 19 filières industrielles et tertiaires pour construire votre carrière en Afrique et dans le monde.
        </p>

        <div class="hero-cta">
            <a href="index.php?action=student_register" class="btn-hero-primary" id="heroRegisterBtn">
                <i class="fas fa-user-plus" aria-hidden="true"></i>
                Rejoindre l'EPI
            </a>
            <a href="index.php?action=formations" class="btn-hero-ghost" id="heroFormationsBtn">
                <i class="fas fa-book-open" aria-hidden="true"></i>
                Nos 19 filières
            </a>
        </div>
    </div>

    <div class="scroll-hint" aria-hidden="true">
        <span>DÉFILER</span>
        <i class="fas fa-chevron-down"></i>
    </div>
</section>

<!-- ═══════════ STATS BAR ═══════════ -->
<section class="stats-bar" aria-label="Chiffres clés de l'école">
    <div class="container">
        <div class="stats-bar-inner">
            <div class="stat-item">
                <div class="stat-number" id="statStudents" data-target="150">0</div>
                <div class="stat-label">Diplômés formés</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" id="statPrograms" data-target="19">0</div>
                <div class="stat-label">Filières BTS</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" id="statYears" data-target="5">0</div>
                <div class="stat-label">Années d'excellence</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" id="statPartners" data-target="15">0</div>
                <div class="stat-label">Partenaires entreprises</div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════ PROGRAMMES ═══════════ -->
<section class="section-white" id="programmes" aria-labelledby="prog-heading">
    <div class="container">
        <header class="section-header">
            <div class="section-tag anim"><i class="fas fa-layer-group"></i> Nos programmes</div>
            <h2 class="section-title anim anim-d1" id="prog-heading">Des formations pensées<br>pour l'industrie</h2>
            <p class="section-sub anim anim-d2">
                Quatre pôles d'excellence pour vous préparer aux métiers d'avenir.
            </p>
        </header>

        <div class="programs-grid">
            <article class="program-card anim anim-d1">
                <div class="program-icon" aria-hidden="true"><i class="fas fa-hard-hat"></i></div>
                <h3 class="program-title">Génie Civil</h3>
                <p class="program-desc">
                    3 options : Travaux Publics, Bâtiment et Géomètre Topographe.
                    La référence pour les métiers de la construction en Afrique.
                </p>
                <div class="program-tags">
                    <span class="p-tag"><i class="fas fa-clock"></i> 2 ans BTS</span>
                    <span class="p-tag"><i class="fas fa-industry"></i> Industriel</span>
                </div>
                <a href="index.php?action=formations" class="program-link">
                    Découvrir <i class="fas fa-arrow-right"></i>
                </a>
            </article>

            <article class="program-card anim anim-d2">
                <div class="program-icon" aria-hidden="true"><i class="fas fa-laptop-code"></i></div>
                <h3 class="program-title">Informatique & Réseaux</h3>
                <p class="program-desc">
                    Développeur d'Application et Réseaux Informatiques & Télécoms.
                    Deux filières tech au cœur de la transformation numérique.
                </p>
                <div class="program-tags">
                    <span class="p-tag"><i class="fas fa-clock"></i> 2 ans BTS</span>
                    <span class="p-tag"><i class="fas fa-industry"></i> Industriel</span>
                </div>
                <a href="index.php?action=formations" class="program-link">
                    Découvrir <i class="fas fa-arrow-right"></i>
                </a>
            </article>

            <article class="program-card anim anim-d3">
                <div class="program-icon" aria-hidden="true"><i class="fas fa-chart-line"></i></div>
                <h3 class="program-title">Finance & Gestion</h3>
                <p class="program-desc">
                    Finance Comptabilité, Gestion Commerciale, RH et Assistanat de Direction.
                    Le pôle tertiaire de l'EPI pour les métiers de l'économie.
                </p>
                <div class="program-tags">
                    <span class="p-tag"><i class="fas fa-clock"></i> 2 ans BTS</span>
                    <span class="p-tag"><i class="fas fa-briefcase"></i> Tertiaire</span>
                </div>
                <a href="index.php?action=formations" class="program-link">
                    Découvrir <i class="fas fa-arrow-right"></i>
                </a>
            </article>

            <article class="program-card anim anim-d4">
                <div class="program-icon" aria-hidden="true"><i class="fas fa-seedling"></i></div>
                <h3 class="program-title">Agriculture & Environnement</h3>
                <p class="program-desc">
                    Agriculture Tropicale (Production Animale & Végétale) et Gestion
                    de l'Environnement. Former les acteurs du développement durable.
                </p>
                <div class="program-tags">
                    <span class="p-tag"><i class="fas fa-clock"></i> 2 ans BTS</span>
                    <span class="p-tag"><i class="fas fa-industry"></i> Industriel</span>
                </div>
                <a href="index.php?action=formations" class="program-link">
                    Découvrir <i class="fas fa-arrow-right"></i>
                </a>
            </article>
        </div>
    </div>
</section>

<!-- ═══════════ POURQUOI EPI ═══════════ -->
<section class="section-dark" id="pourquoi" aria-labelledby="why-heading">
    <div class="container">
        <header class="section-header">
            <div class="section-tag anim"><i class="fas fa-star"></i> Pourquoi choisir l'EPI</div>
            <h2 class="section-title anim anim-d1" id="why-heading">Ce qui fait l'EPI</h2>
            <p class="section-sub anim anim-d2">
                Trois piliers qui font de l'EPI Yamoussoukro une école de référence
                en Côte d'Ivoire et dans la sous-région africaine.
            </p>
        </header>

        <div class="features-grid">
            <div class="feature-card anim anim-d1">
                <div class="feature-icon" aria-hidden="true"><i class="fas fa-trophy"></i></div>
                <h3 class="feature-title">Excellence Académique</h3>
                <p class="feature-desc">
                    Corps enseignant composé d'experts et de chercheurs reconnus.
                    Programmes constamment mis à jour pour refléter les dernières avancées technologiques.
                </p>
            </div>
            <div class="feature-card anim anim-d2">
                <div class="feature-icon" aria-hidden="true"><i class="fas fa-lightbulb"></i></div>
                <h3 class="feature-title">Innovation & Pratique</h3>
                <p class="feature-desc">
                    Des laboratoires équipés de pointe, des projets industriels réels dès la 1ère année,
                    et une pédagogie axée sur le "learning by doing".
                </p>
            </div>
            <div class="feature-card anim anim-d3">
                <div class="feature-icon" aria-hidden="true"><i class="fas fa-briefcase"></i></div>
                <h3 class="feature-title">Insertion Professionnelle</h3>
                <p class="feature-desc">
                    Réseau de plus de 120 entreprises partenaires, cellule carrière dédiée
                    et un taux d'insertion de 95% dans les 6 mois suivant la diplomation.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════ CTA BANNIÈRE ═══════════ -->
<section class="cta-section" aria-label="Appel à l'action">
    <div class="hero-grid" aria-hidden="true"></div>
    <div class="container cta-content">
        <h2 class="cta-title anim">
            Prêt à commencer<br>votre avenir à l'EPI ?
        </h2>
        <p class="cta-sub anim anim-d1">
            Créez votre espace étudiant et rejoignez l'une des 19 filières de
            l'École Polytechnique Internationale de Yamoussoukro.
        </p>
        <div class="hero-cta anim anim-d2">
            <a href="index.php?action=student_register" class="btn-hero-primary" id="ctaRegisterBtn">
                <i class="fas fa-user-plus"></i>
                Créer mon compte
            </a>
            <a href="index.php?action=contact" class="btn-hero-ghost" id="ctaContactBtn">
                <i class="fas fa-envelope"></i>
                Nous contacter
            </a>
        </div>
    </div>
</section>
</main>

<!-- Counter animation script -->
<script>
(function () {
    function animateCounter(el) {
        var target = parseInt(el.getAttribute('data-target'), 10);
        var suffix = target >= 1000 ? '+' : (el.id === 'statPrograms' ? '' : '+');
        var duration = 1800;
        var start = performance.now();
        function update(now) {
            var elapsed = now - start;
            var progress = Math.min(elapsed / duration, 1);
            // ease out
            var val = Math.floor(progress * progress * (3 - 2 * progress) * target);
            el.textContent = (target >= 1000 ? val.toLocaleString('fr-FR') : val) + suffix;
            if (progress < 1) requestAnimationFrame(update);
            else el.textContent = (target >= 1000 ? target.toLocaleString('fr-FR') : target) + suffix;
        }
        requestAnimationFrame(update);
    }

    var counters = document.querySelectorAll('.stat-number[data-target]');
    var observed = false;
    var obs = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
            if (e.isIntersecting && !observed) {
                observed = true;
                counters.forEach(function (c) { animateCounter(c); });
            }
        });
    }, { threshold: 0.3 });

    if (counters.length) obs.observe(counters[0].closest('.stats-bar') || counters[0]);
})();
</script>

<?php require_once __DIR__ . '/../layout/public_footer.php'; ?>
