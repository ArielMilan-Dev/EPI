<?php
/**
 * En-tête public — navbar transparente qui devient opaque au défilement.
 * Requiert que $pageTitle et $currentPage soient définis dans la vue appelante.
 */
$currentPage = $_GET['action'] ?? 'home';
$isStudent   = isset($_SESSION['student_id']);
?>
<!DOCTYPE html>
<html lang="fr">
<!-- EPI Yamoussoukro — École Polytechnique Internationale -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'EPI - École Polytechnique Internationale de Yamoussoukro') ?></title>
    <meta name="description" content="EPI Yamoussoukro — École Polytechnique Internationale. Formations industrielles et tertiaires de haut niveau en Côte d'Ivoire.">
    <meta name="theme-color" content="#1a2b4a">

    <!-- Preconnect fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Feuille de style publique -->
    <link rel="stylesheet" href="public/css/website.css">
</head>
<body>

<!-- ═══════════ NAVBAR ═══════════ -->
<nav class="site-navbar transparent" id="siteNavbar" role="navigation" aria-label="Navigation principale">
    <div class="container">
        <div class="navbar-inner">

            <!-- Brand -->
            <a href="index.php?action=home" class="navbar-brand" aria-label="EPI Yamoussoukro — Accueil">
                <img src="public/images/logoepi.png"
                     alt="Logo EPI"
                     class="navbar-real-logo"
                     width="52" height="52">
                <div class="navbar-brand-text">
                    <span class="brand-name">EPI</span>
                    <span class="brand-sub">École Polytechnique Internationale · Yamoussoukro</span>
                </div>
            </a>

            <!-- Liens de navigation -->
            <ul class="navbar-links" id="navLinks" role="list">
                <li>
                    <a href="index.php?action=home"
                       class="<?= $currentPage === 'home' ? 'active' : '' ?>">
                        Accueil
                    </a>
                </li>
                <li>
                    <a href="index.php?action=formations"
                       class="<?= $currentPage === 'formations' ? 'active' : '' ?>">
                        Formations
                    </a>
                </li>
                <li>
                    <a href="index.php?action=contact"
                       class="<?= $currentPage === 'contact' ? 'active' : '' ?>">
                        Contact
                    </a>
                </li>
            </ul>

            <!-- Actions -->
            <div class="navbar-actions" id="navActions">
                <?php if ($isStudent): ?>
                    <a href="index.php?action=student_portal" class="btn-nav btn-nav-ghost">
                        <i class="fas fa-user-circle"></i> Mon Espace
                    </a>
                    <a href="index.php?action=student_logout" class="btn-nav btn-nav-accent">
                        <i class="fas fa-sign-out-alt"></i> Déconnexion
                    </a>
                <?php else: ?>
                    <a href="index.php?action=student_login" class="btn-nav btn-nav-ghost">
                        Se connecter
                    </a>
                    <a href="index.php?action=student_register" class="btn-nav btn-nav-accent">
                        <i class="fas fa-user-plus"></i> S'inscrire
                    </a>
                <?php endif; ?>
            </div>

            <!-- Hamburger mobile -->
            <button class="navbar-toggle" id="navToggle" aria-label="Ouvrir le menu" aria-expanded="false">
                <i class="fas fa-bars" id="toggleIcon"></i>
            </button>
        </div>
    </div>
</nav>

<!-- Drawer mobile -->
<div class="mobile-drawer" id="mobileDrawer" role="navigation" aria-label="Menu mobile">
    <a href="index.php?action=home"><i class="fas fa-home"></i> Accueil</a>
    <a href="index.php?action=formations"><i class="fas fa-book-open"></i> Formations</a>
    <a href="index.php?action=contact"><i class="fas fa-envelope"></i> Contact</a>
    <div class="drawer-divider"></div>
    <?php if ($isStudent): ?>
        <a href="index.php?action=student_portal"><i class="fas fa-tachometer-alt"></i> Mon Espace</a>
        <a href="index.php?action=student_logout"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
    <?php else: ?>
        <a href="index.php?action=student_login"><i class="fas fa-sign-in-alt"></i> Se connecter</a>
        <a href="index.php?action=student_register"><i class="fas fa-user-plus"></i> S'inscrire</a>
    <?php endif; ?>
</div>

<script>
// Navbar scroll effect
(function () {
    const nav    = document.getElementById('siteNavbar');
    const toggle = document.getElementById('navToggle');
    const drawer = document.getElementById('mobileDrawer');
    const icon   = document.getElementById('toggleIcon');

    // Scroll → opaque
    function onScroll() {
        if (window.scrollY > 30) {
            nav.classList.replace('transparent', 'scrolled');
        } else {
            nav.classList.replace('scrolled', 'transparent');
        }
    }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();

    // Mobile toggle
    toggle.addEventListener('click', function () {
        const open = drawer.classList.toggle('open');
        toggle.setAttribute('aria-expanded', open);
        icon.className = open ? 'fas fa-times' : 'fas fa-bars';
    });
})();
</script>
