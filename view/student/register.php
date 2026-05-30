<?php
$pageTitle = $pageTitle ?? "Inscription Étudiant — EPI";
$old = $old ?? [];

$classes = [
    // Filières Industrielles
    'Génie Civil Option Travaux Publics',
    'Génie Civil Option Bâtiment',
    'Génie Civil Option Géomètre Topographe',
    'Mines Géologie et Pétrole',
    'Électrotechnique',
    'Réseaux Informatiques et Télécoms',
    'Agriculture Tropicale Option Production Animale',
    'Agriculture Tropicale Option Production Végétale',
    'Gestion de l\'Environnement et des Ressources Naturelles',
    'Maintenance des Systèmes de Production',
    'Informatique Développeur d\'Application',
    'Moteur et Mécanique Automobile',
    'Génie Énergétique et Environnement',
    // Filières Tertiaires
    'Finance Comptabilité et Gestion des Entreprises',
    'Gestion Commerciale',
    'Ressources Humaines et Communication',
    'Logistique',
    'Tourisme Hôtellerie',
    'Assistanat de Direction',
];

$industrielles = array_slice($classes, 0, 13);
$tertiaires    = array_slice($classes, 13);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <meta name="description" content="Créez votre espace étudiant EPI gratuitement.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/website.css">
    <style>
        /* Scrollable auth card pour le grand formulaire */
        .auth-page { align-items: flex-start; }
        .auth-wrapper { max-width: 620px; }
    </style>
</head>
<body>

<div class="auth-page">
    <div class="hero-grid" aria-hidden="true"></div>
    <div class="hero-orbs" aria-hidden="true">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
    </div>

    <div class="auth-wrapper">

        <a href="index.php?action=home" class="auth-back-link">
            <i class="fas fa-arrow-left"></i> Retour à l'accueil
        </a>

        <div class="auth-card">

            <!-- Logo + titre -->
            <div class="auth-logo">
                <div class="auth-logo-icon" aria-hidden="true">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h1 class="auth-title">Créer un compte</h1>
                <p class="auth-subtitle">Rejoignez la communauté EPI gratuitement</p>
            </div>

            <!-- Alerte erreur -->
            <?php if (!empty($error)): ?>
                <div class="alert alert-error" role="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <!-- Formulaire d'inscription -->
            <form method="POST" action="index.php?action=student_register" class="auth-form" novalidate id="registerForm">

                <!-- Prénom / Nom -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="r-firstname">Prénom <span class="req">*</span></label>
                        <div class="input-wrap">
                            <i class="fas fa-user" aria-hidden="true"></i>
                            <input
                                type="text"
                                id="r-firstname"
                                name="first_name"
                                class="auth-input"
                                placeholder="Prénom"
                                required autocomplete="given-name"
                                value="<?= htmlspecialchars($old['first_name'] ?? '') ?>"
                            >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="r-lastname">Nom <span class="req">*</span></label>
                        <div class="input-wrap">
                            <i class="fas fa-user" aria-hidden="true"></i>
                            <input
                                type="text"
                                id="r-lastname"
                                name="last_name"
                                class="auth-input"
                                placeholder="Nom de famille"
                                required autocomplete="family-name"
                                value="<?= htmlspecialchars($old['last_name'] ?? '') ?>"
                            >
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="r-email">Adresse email <span class="req">*</span></label>
                    <div class="input-wrap">
                        <i class="fas fa-envelope" aria-hidden="true"></i>
                        <input
                            type="email"
                            id="r-email"
                            name="email"
                            class="auth-input"
                            placeholder="votre@email.com"
                            required autocomplete="email"
                            value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                        >
                    </div>
                </div>

                <!-- Téléphone / Date de naissance -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="r-phone">Téléphone</label>
                        <div class="input-wrap">
                            <i class="fas fa-phone" aria-hidden="true"></i>
                            <input
                                type="tel"
                                id="r-phone"
                                name="phone"
                                class="auth-input"
                                placeholder="Ex: 55 000 000"
                                autocomplete="tel"
                                value="<?= htmlspecialchars($old['phone'] ?? '') ?>"
                            >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="r-birth">Date de naissance <span class="req">*</span></label>
                        <div class="input-wrap">
                            <i class="fas fa-calendar-alt" aria-hidden="true"></i>
                            <input
                                type="date"
                                id="r-birth"
                                name="birth_date"
                                class="auth-input"
                                required
                                max="<?= date('Y-m-d', strtotime('-15 years')) ?>"
                                value="<?= htmlspecialchars($old['birth_date'] ?? '') ?>"
                            >
                        </div>
                    </div>
                </div>

                <!-- Filière -->
                <div class="form-group">
                    <label for="r-class">Filière / Classe <span class="req">*</span></label>
                    <div class="input-wrap">
                        <i class="fas fa-layer-group" aria-hidden="true"></i>
                        <select id="r-class" name="class_name" class="auth-input" required>
                            <option value="">— Choisissez votre filière —</option>
                            <optgroup label="🏗️ Filières Industrielles">
                                <?php foreach ($industrielles as $c): ?>
                                    <option value="<?= htmlspecialchars($c) ?>"
                                        <?= ($old['class_name'] ?? '') === $c ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($c) ?>
                                    </option>
                                <?php endforeach; ?>
                            </optgroup>
                            <optgroup label="💼 Filières Tertiaires">
                                <?php foreach ($tertiaires as $c): ?>
                                    <option value="<?= htmlspecialchars($c) ?>"
                                        <?= ($old['class_name'] ?? '') === $c ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($c) ?>
                                    </option>
                                <?php endforeach; ?>
                            </optgroup>
                        </select>
                    </div>
                </div>

                <!-- Mot de passe -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="r-password">Mot de passe <span class="req">*</span></label>
                        <div class="input-wrap">
                            <i class="fas fa-lock" aria-hidden="true"></i>
                            <input
                                type="password"
                                id="r-password"
                                name="password"
                                class="auth-input"
                                placeholder="Min. 6 caractères"
                                required autocomplete="new-password"
                                minlength="6"
                            >
                            <span class="pw-toggle" id="pwToggle1" role="button" aria-label="Voir le mot de passe" tabindex="0">
                                <i class="fas fa-eye" id="pwIcon1"></i>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="r-confirm">Confirmer <span class="req">*</span></label>
                        <div class="input-wrap">
                            <i class="fas fa-lock" aria-hidden="true"></i>
                            <input
                                type="password"
                                id="r-confirm"
                                name="confirm_password"
                                class="auth-input"
                                placeholder="Répétez le mot de passe"
                                required autocomplete="new-password"
                            >
                            <span class="pw-toggle" id="pwToggle2" role="button" aria-label="Voir" tabindex="0">
                                <i class="fas fa-eye" id="pwIcon2"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Password strength indicator -->
                <div id="strengthWrap" style="margin-top:-8px; margin-bottom:16px; display:none;">
                    <div style="height:4px;border-radius:4px;background:var(--border);overflow:hidden;">
                        <div id="strengthBar" style="height:100%;width:0;transition:all .3s;border-radius:4px;"></div>
                    </div>
                    <div id="strengthLabel" style="font-size:11px;color:rgba(255,255,255,.5);margin-top:5px;"></div>
                </div>

                <button type="submit" class="btn-auth" id="registerSubmitBtn">
                    <i class="fas fa-user-plus"></i>
                    Créer mon compte EPI
                </button>

                <p style="font-size:12px;color:rgba(255,255,255,.35);text-align:center;margin-top:14px;line-height:1.6;">
                    En créant un compte, vous acceptez nos conditions d'utilisation
                    et notre politique de confidentialité.
                </p>
            </form>

            <div class="auth-switch">
                Déjà un compte ?
                <a href="index.php?action=student_login">Se connecter</a>
            </div>

        </div><!-- /auth-card -->
    </div><!-- /auth-wrapper -->
</div>

<script>
// Password toggles
(function () {
    function makeToggle(toggleId, inputId, iconId) {
        var toggle = document.getElementById(toggleId);
        var input  = document.getElementById(inputId);
        var icon   = document.getElementById(iconId);
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
    }
    makeToggle('pwToggle1', 'r-password', 'pwIcon1');
    makeToggle('pwToggle2', 'r-confirm',  'pwIcon2');

    // Password strength
    var pwInput   = document.getElementById('r-password');
    var swrap     = document.getElementById('strengthWrap');
    var sbar      = document.getElementById('strengthBar');
    var slabel    = document.getElementById('strengthLabel');
    var levels    = [
        { min: 0,  color: '#ef4444', label: 'Très faible' },
        { min: 1,  color: '#f97316', label: 'Faible'       },
        { min: 2,  color: '#f0a500', label: 'Moyen'        },
        { min: 3,  color: '#84cc16', label: 'Fort'         },
        { min: 4,  color: '#22c55e', label: 'Très fort'    },
    ];
    pwInput.addEventListener('input', function () {
        var v = pwInput.value;
        if (!v) { swrap.style.display = 'none'; return; }
        swrap.style.display = 'block';
        var score = 0;
        if (v.length >= 8)          score++;
        if (/[A-Z]/.test(v))        score++;
        if (/[0-9]/.test(v))        score++;
        if (/[^A-Za-z0-9]/.test(v)) score++;
        var lvl = levels[Math.min(score, 4)];
        sbar.style.width  = ((score + 1) / 5 * 100) + '%';
        sbar.style.background = lvl.color;
        slabel.textContent = 'Force : ' + lvl.label;
        slabel.style.color = lvl.color;
    });

    // Confirm match
    var cInput = document.getElementById('r-confirm');
    cInput.addEventListener('input', function () {
        if (cInput.value && cInput.value !== pwInput.value) {
            cInput.style.borderColor = '#ef4444';
        } else {
            cInput.style.borderColor = '';
        }
    });
})();
</script>
</body>
</html>
