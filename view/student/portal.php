<?php
$pageTitle = $pageTitle ?? "Mon Espace — EPI";
$initials  = strtoupper(substr($student['first_name'] ?? 'E', 0, 1) . substr($student['last_name'] ?? 'P', 0, 1));
$fullName  = htmlspecialchars(($student['first_name'] ?? '') . ' ' . ($student['last_name'] ?? ''));
$joinDate  = !empty($student['created_at'])
    ? (new DateTime($student['created_at']))->format('d/m/Y')
    : '—';
$birthDate = !empty($student['birth_date'])
    ? (new DateTime($student['birth_date']))->format('d/m/Y')
    : '—';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <meta name="description" content="Votre espace étudiant EPI — informations personnelles et académiques.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/website.css">
</head>
<body>

<div class="portal-page">

    <!-- ═══ PORTAL HEADER ═══ -->
    <header class="portal-hero" role="banner">
        <div class="hero-grid" aria-hidden="true"></div>
        <div class="hero-orbs" aria-hidden="true">
            <div class="orb orb-1" style="opacity:.5"></div>
            <div class="orb orb-2" style="opacity:.4"></div>
        </div>

        <div class="container portal-hero-inner">
            <div>
                <p class="portal-hello">Bienvenue sur votre espace étudiant,</p>
                <h1 class="portal-student-name"><?= $fullName ?></h1>
                <div class="portal-id-pill">
                    <i class="fas fa-id-badge" aria-hidden="true"></i>
                    <?= htmlspecialchars($student['student_id'] ?? 'EPI-???') ?>
                </div>
            </div>

            <div class="portal-right">
                <div class="portal-avatar" aria-label="Avatar de <?= $fullName ?>">
                    <?= $initials ?>
                </div>
                <button type="button" class="portal-logout" id="openStudentPwdBtn" style="background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2); margin-right: 10px;">
                    <i class="fas fa-key" aria-hidden="true"></i> Mot de passe
                </button>
                <a href="index.php?action=student_logout" class="portal-logout" id="portalLogoutBtn">
                    <i class="fas fa-sign-out-alt" aria-hidden="true"></i>
                    Déconnexion
                </a>
            </div>
        </div>
    </header>

    <!-- ═══ PORTAL BODY ═══ -->
    <main class="portal-body" id="main-content">
        <div class="container">

            <!-- Navigation rapide top -->
            <div style="margin-bottom:32px;">
                <a href="index.php?action=home" style="display:inline-flex;align-items:center;gap:8px;color:var(--text-muted);font-size:14px;font-weight:500;transition:var(--transition);"
                   onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--text-muted)'">
                    <i class="fas fa-arrow-left"></i> Retour au site
                </a>
            </div>

            <div class="portal-grid">

                <!-- Card : Informations personnelles -->
                <div class="portal-card anim">
                    <h2 class="portal-card-head">
                        <i class="fas fa-user-circle" aria-hidden="true"></i>
                        Informations personnelles
                    </h2>

                    <div class="info-row">
                        <span class="info-lbl">Prénom</span>
                        <span class="info-val"><?= htmlspecialchars($student['first_name'] ?? '—') ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-lbl">Nom</span>
                        <span class="info-val"><?= htmlspecialchars($student['last_name'] ?? '—') ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-lbl">Date de naissance</span>
                        <span class="info-val"><?= $birthDate ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-lbl">Téléphone</span>
                        <span class="info-val"><?= htmlspecialchars($student['phone'] ?? '—') ?></span>
                    </div>
                </div>

                <!-- Card : Informations académiques -->
                <div class="portal-card anim anim-d1">
                    <h2 class="portal-card-head">
                        <i class="fas fa-university" aria-hidden="true"></i>
                        Informations académiques
                    </h2>

                    <div class="info-row">
                        <span class="info-lbl">Identifiant EPI</span>
                        <span class="info-val" style="color:var(--accent-dark);font-family:monospace;">
                            <?= htmlspecialchars($student['student_id'] ?? '—') ?>
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-lbl">Filière / Classe</span>
                        <span class="info-val">
                            <span class="class-pill">
                                <i class="fas fa-layer-group" aria-hidden="true"></i>
                                <?= htmlspecialchars($student['class_name'] ?? '—') ?>
                            </span>
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-lbl">Email académique</span>
                        <span class="info-val"><?= htmlspecialchars($student['email'] ?? '—') ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-lbl">Date d'inscription</span>
                        <span class="info-val"><?= $joinDate ?></span>
                    </div>
                </div>

                <!-- Card : Liens rapides (pleine largeur) -->
                <div class="portal-card full anim anim-d2">
                    <h2 class="portal-card-head">
                        <i class="fas fa-th-large" aria-hidden="true"></i>
                        Accès rapide
                    </h2>
                    <div class="quick-links">
                        <a href="index.php?action=formations" class="quick-link" id="qlFormations">
                            <i class="fas fa-book-open" aria-hidden="true"></i>
                            Nos formations
                        </a>
                        <a href="index.php?action=contact" class="quick-link" id="qlContact">
                            <i class="fas fa-envelope" aria-hidden="true"></i>
                            Contacter l'école
                        </a>
                        <a href="index.php?action=home" class="quick-link" id="qlHome">
                            <i class="fas fa-home" aria-hidden="true"></i>
                            Site principal
                        </a>
                    </div>
                </div>

            </div><!-- /portal-grid -->

            <!-- Petite note de bas -->
            <p style="text-align:center;color:var(--text-soft);font-size:13px;margin-top:48px;">
                <i class="fas fa-info-circle"></i>
                Pour modifier vos informations, contactez le secrétariat à
                <a href="mailto:epiyamoussoukro@gmail.com" style="color:var(--primary-light)">epiyamoussoukro@gmail.com</a>.
            </p>

        </div>
    </main>

</div>

<!-- Modale Mot de Passe Étudiant -->
<div class="modal-overlay" id="studentPwdModal">
    <div class="modal-content" style="max-width: 450px;">
        <div class="modal-header">
            <h2 class="modal-title">Modifier mon mot de passe</h2>
            <button class="modal-close" id="closeStudentPwdBtn"><i class="fas fa-times"></i></button>
        </div>
        <form id="studentPwdForm">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Ancien mot de passe</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock" aria-hidden="true" style="color:var(--text-muted);left:14px;top:50%;transform:translateY(-50%);position:absolute;"></i>
                        <input type="password" name="old_password" id="oldPwdInput" class="form-control" style="padding-left: 42px;" required>
                        <span class="pw-toggle" id="toggleOldPwd" role="button" tabindex="0">
                            <i class="fas fa-eye" id="iconOldPwd"></i>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Nouveau mot de passe</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock" aria-hidden="true" style="color:var(--text-muted);left:14px;top:50%;transform:translateY(-50%);position:absolute;"></i>
                        <input type="password" name="new_password" id="newPwdInput" class="form-control" style="padding-left: 42px;" required minlength="6">
                        <span class="pw-toggle" id="toggleNewPwd" role="button" tabindex="0">
                            <i class="fas fa-eye" id="iconNewPwd"></i>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Confirmer le nouveau mot de passe</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock" aria-hidden="true" style="color:var(--text-muted);left:14px;top:50%;transform:translateY(-50%);position:absolute;"></i>
                        <input type="password" name="confirm_password" id="confirmPwdInput" class="form-control" style="padding-left: 42px;" required>
                        <span class="pw-toggle" id="toggleConfirmPwd" role="button" tabindex="0">
                            <i class="fas fa-eye" id="iconConfirmPwd"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="cancelStudentPwdBtn" style="width: auto;">Annuler</button>
                <button type="submit" class="btn btn-primary" style="width: auto;">Mettre à jour</button>
            </div>
        </form>
    </div>
</div>

<!-- Conteneur des toasts (notifications) -->
<div class="toast-container" id="toastContainer"></div>

<!-- Scroll-reveal -->
<script>
(function () {
    var elems = document.querySelectorAll('.anim');
    if (!elems.length) return;
    var obs = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
            if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); }
        });
    }, { threshold: 0.1 });
    elems.forEach(function (el) { obs.observe(el); });
})();

// Toasts function
function showToast(message, type = 'success') {
    const container = document.getElementById('toastContainer');
    if (!container) return;
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    const iconClass = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';
    toast.innerHTML = `
        <div class="toast-content">
            <i class="${iconClass} toast-icon"></i>
            <span class="toast-text">${message}</span>
        </div>
    `;
    container.appendChild(toast);
    setTimeout(() => toast.classList.add('show'), 10);
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Modal & Form Logic
(function () {
    const modal = document.getElementById('studentPwdModal');
    const openBtn = document.getElementById('openStudentPwdBtn');
    const closeBtn = document.getElementById('closeStudentPwdBtn');
    const cancelBtn = document.getElementById('cancelStudentPwdBtn');
    const form = document.getElementById('studentPwdForm');

    function openModal() {
        if(modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }
    function closeModal() {
        if(modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
            if(form) form.reset();
        }
    }

    if (openBtn) openBtn.addEventListener('click', openModal);
    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    if (cancelBtn) cancelBtn.addEventListener('click', closeModal);
    window.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });

    // Password Toggles
    function setupToggle(toggleId, inputId, iconId) {
        const toggle = document.getElementById(toggleId);
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if(!toggle || !input || !icon) return;
        const doToggle = () => {
            const isText = input.type === 'text';
            input.type = isText ? 'password' : 'text';
            icon.className = isText ? 'fas fa-eye' : 'fas fa-eye-slash';
        };
        toggle.addEventListener('click', doToggle);
        toggle.addEventListener('keydown', (e) => {
            if(e.key === 'Enter' || e.key === ' ') { e.preventDefault(); doToggle(); }
        });
    }

    setupToggle('toggleOldPwd', 'oldPwdInput', 'iconOldPwd');
    setupToggle('toggleNewPwd', 'newPwdInput', 'iconNewPwd');
    setupToggle('toggleConfirmPwd', 'confirmPwdInput', 'iconConfirmPwd');

    // Form Submission
    if (form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(form);
            fetch('index.php?action=ajax_update_student_pwd', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message, "success");
                    closeModal();
                } else {
                    showToast(data.message, "error");
                }
            })
            .catch(err => {
                console.error(err);
                showToast("Erreur lors de la mise à jour.", "error");
            });
        });
    }
})();
</script>

</body>
</html>
