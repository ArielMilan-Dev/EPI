<?php
$pageTitle = $pageTitle ?? "Connexion Étudiant — EPI";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <meta name="description" content="Connectez-vous à votre espace étudiant EPI.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/website.css">
</head>
<body>

<div class="auth-page">
    <!-- Décor -->
    <div class="hero-grid" aria-hidden="true"></div>
    <div class="hero-orbs" aria-hidden="true">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
    </div>

    <div class="auth-wrapper">

        <!-- Retour -->
        <a href="index.php?action=home" class="auth-back-link">
            <i class="fas fa-arrow-left"></i> Retour à l'accueil
        </a>

        <div class="auth-card">

            <!-- Logo + titre -->
            <div class="auth-logo">
                <div class="auth-logo-icon" aria-hidden="true">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h1 class="auth-title">Espace Étudiant</h1>
                <p class="auth-subtitle">Connectez-vous à votre compte EPI</p>
            </div>

            <!-- Alerte erreur -->
            <?php if (!empty($error)): ?>
                <div class="alert alert-error" role="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <!-- Formulaire -->
            <form method="POST" action="index.php?action=student_login" class="auth-form" novalidate id="loginForm">

                <div class="form-group">
                    <label for="login-email">
                        Adresse email <span class="req">*</span>
                    </label>
                    <div class="input-wrap">
                        <i class="fas fa-envelope" aria-hidden="true"></i>
                        <input
                            type="email"
                            id="login-email"
                            name="email"
                            class="auth-input"
                            placeholder="votre@email.com"
                            autocomplete="email"
                            required
                            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="login-password">
                        Mot de passe <span class="req">*</span>
                    </label>
                    <div class="input-wrap">
                        <i class="fas fa-lock" aria-hidden="true"></i>
                        <input
                            type="password"
                            id="login-password"
                            name="password"
                            class="auth-input"
                            placeholder="••••••••"
                            autocomplete="current-password"
                            required
                        >
                        <span class="pw-toggle" id="pwToggle" role="button" aria-label="Afficher/masquer le mot de passe" tabindex="0">
                            <i class="fas fa-eye" id="pwIcon"></i>
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn-auth" id="loginSubmitBtn">
                    <i class="fas fa-sign-in-alt"></i>
                    Se connecter
                </button>
            </form>

            <div class="auth-divider">ou</div>

            <div class="auth-switch">
                Pas encore de compte ?
                <a href="index.php?action=student_register">Créer un compte</a>
            </div>

            <div class="auth-switch" style="margin-top:10px;">
                Vous êtes administrateur ?
                <a href="index.php?action=login">Connexion Admin</a>
            </div>

        </div><!-- /auth-card -->
    </div><!-- /auth-wrapper -->
</div>

<script>
// Password toggle
(function () {
    var toggle = document.getElementById('pwToggle');
    var input  = document.getElementById('login-password');
    var icon   = document.getElementById('pwIcon');
    if (!toggle) return;
    function doToggle() {
        var shown = input.type === 'text';
        input.type = shown ? 'password' : 'text';
        icon.className = shown ? 'fas fa-eye' : 'fas fa-eye-slash';
    }
    toggle.addEventListener('click', doToggle);
    toggle.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); doToggle(); }
    });
})();
</script>
</body>
</html>
