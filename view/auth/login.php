<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="theme-toggle-container">
    <button class="theme-toggle-btn" id="themeToggleBtn" title="Changer de thème">
        <i class="fas fa-moon"></i>
    </button>
</div>

<div class="auth-wrapper">
    <!-- Glow effects -->
    <div class="auth-bg-glow"></div>
    <div class="auth-bg-glow-2"></div>

    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-logo">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <h2 class="auth-title">EPI Scolarité</h2>
            <p class="auth-subtitle">Connectez-vous pour gérer les étudiants</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle"></i>
                <span><?= htmlspecialchars($error) ?></span>
            </div>
        <?php endif; ?>

        <form action="index.php?action=login" method="POST" id="loginForm">
            <div class="form-group">
                <label class="form-label" for="username">Nom d'utilisateur</label>
                <div class="input-wrapper">
                    <input type="text" name="username" id="username" class="form-control" placeholder="Ex: admin" required autocomplete="username">
                    <i class="fas fa-user input-icon"></i>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Mot de passe</label>
                <div class="input-wrapper">
                    <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required autocomplete="current-password">
                    <i class="fas fa-lock input-icon"></i>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="margin-top: 10px;">
                <i class="fas fa-sign-in-alt"></i> Se connecter
            </button>
        </form>

        <div style="margin-top: 30px; padding: 12px; background: rgba(99, 102, 241, 0.05); border: 1px dashed rgba(99, 102, 241, 0.2); border-radius: 8px; font-size: 0.8rem; text-align: center; color: var(--text-secondary);">
            <i class="fas fa-info-circle" style="color: var(--accent); margin-right: 4px;"></i>
            Identifiants démo : <strong style="color: var(--text-primary);">admin</strong> / <strong style="color: var(--text-primary);">admin123</strong>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
