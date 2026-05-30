<?php require_once __DIR__ . '/layout/header.php'; ?>

<div class="portal-page">

    <!-- ═══ ADMIN HEADER ═══ -->
    <header class="portal-hero" role="banner" style="margin-bottom: 0;">
        <div class="hero-grid" aria-hidden="true"></div>
        <div class="hero-orbs" aria-hidden="true">
            <div class="orb orb-1" style="opacity:.5"></div>
            <div class="orb orb-2" style="opacity:.4"></div>
        </div>

        <div class="container portal-hero-inner">
            <div>
                <p class="portal-hello">Espace d'Administration</p>
                <h1 class="portal-student-name">EPI Scolarité</h1>
            </div>

            <div class="portal-right">
                <div class="admin-badge" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: white;">
                    <div class="admin-avatar">
                        <?= strtoupper(substr($admin_name ?? 'A', 0, 1)) ?>
                    </div>
                    <span class="admin-name" style="color: white;"><?= htmlspecialchars($admin_name ?? 'Admin') ?></span>
                </div>
                <button type="button" class="portal-logout" id="openProfileBtn" style="background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2);">
                    <i class="fas fa-cog"></i> Profil
                </button>
                <a href="index.php?action=logout" class="portal-logout">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </a>
            </div>
        </div>
    </header>

    <!-- ═══ ADMIN BODY ═══ -->
    <main class="portal-body" style="padding-top: 30px;">
        <div class="container dashboard-container" style="padding: 0; max-width: 1200px;">
            
            <!-- Navigation rapide top -->
            <div style="margin-bottom:32px;">
                <a href="index.php?action=home" style="display:inline-flex;align-items:center;gap:8px;color:var(--text-muted);font-size:14px;font-weight:500;transition:var(--transition);"
                   onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--text-muted)'">
                    <i class="fas fa-arrow-left"></i> Retour au site
                </a>
            </div>

            <!-- Section Statistiques -->
            <section class="stats-grid">
        <div class="stat-card">
            <div class="stat-info">
                <h3>Total Étudiants</h3>
                <div class="stat-number" id="statTotal"><?= $stats['total_students'] ?? 0 ?></div>
            </div>
            <div class="stat-icon stat-icon-students">
                <i class="fas fa-user-graduate"></i>
            </div>
        </div>

        <div class="stat-card stat-classes">
            <div class="stat-info">
                <h3>Classes Distinctes</h3>
                <div class="stat-number" id="statClasses"><?= $stats['total_classes'] ?? 0 ?></div>
            </div>
            <div class="stat-icon stat-icon-classes">
                <i class="fas fa-university"></i>
            </div>
        </div>

        <div class="stat-card stat-new">
            <div class="stat-info">
                <h3>Inscrits (30j)</h3>
                <div class="stat-number" id="statNew"><?= $stats['new_enrollments'] ?? 0 ?></div>
            </div>
            <div class="stat-icon stat-icon-new">
                <i class="fas fa-user-plus"></i>
            </div>
        </div>
    </section>

    <!-- Table Section -->
    <section class="table-section">
        <div class="table-controls">
            <div class="search-filter-group">
                <div class="search-input-wrapper">
                    <input type="text" id="searchInput" class="search-control" placeholder="Rechercher par identifiant, nom, email...">
                    <i class="fas fa-search input-icon" style="left: 14px;"></i>
                </div>
                
                <select id="classFilter" class="filter-select">
                    <option value="">Toutes les classes</option>
                    <?php if (isset($classes)): ?>
                        <?php foreach ($classes as $cls): ?>
                            <option value="<?= htmlspecialchars($cls) ?>"><?= htmlspecialchars($cls) ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <button class="btn btn-primary table-action-btn" id="openAddModalBtn">
                <i class="fas fa-plus"></i> Enregistrer un étudiant
            </button>
        </div>

        <div class="table-responsive">
            <table class="student-table">
                <thead>
                    <tr>
                        <th>Identifiant</th>
                        <th>Nom & Prénom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Classe</th>
                        <th>Date d'inscription</th>
                        <th style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody id="studentTableBody">
                    <!-- Rempli dynamiquement en AJAX -->
                </tbody>
            </table>
        </div>
    </section>

        </div> <!-- /container -->
    </main> <!-- /portal-body -->
</div> <!-- /portal-page -->

<!-- ================= MODAL AJOUT ETUDIANT ================= -->
<div class="modal-overlay" id="addModal">
    <div class="modal-card">
        <div class="modal-header">
            <h3 class="modal-title"><i class="fas fa-user-plus"></i> Nouvel Étudiant</h3>
            <button class="modal-close" id="closeAddModalBtn"><i class="fas fa-times"></i></button>
        </div>
        <form id="addForm">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Identifiant Unique</label>
                    <div class="id-input-group">
                        <input type="text" name="student_id" class="form-control" style="padding-left: 14px;" placeholder="Ex: EPI-2026-1024" required>
                        <button type="button" class="btn btn-secondary" id="generateAddIdBtn" title="Générer un ID automatiquement">
                            <i class="fas fa-magic"></i>
                        </button>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div class="form-group">
                        <label class="form-label">Prénom</label>
                        <input type="text" name="first_name" class="form-control" style="padding-left: 14px;" placeholder="Ex: Karim" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nom</label>
                        <input type="text" name="last_name" class="form-control" style="padding-left: 14px;" placeholder="Ex: Trabelsi" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Adresse Email</label>
                    <input type="email" name="email" class="form-control" style="padding-left: 14px;" placeholder="Ex: karim.trabelsi@epi.tn" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Téléphone</label>
                    <input type="tel" name="phone" class="form-control" style="padding-left: 14px;" placeholder="Ex: 55443322">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div class="form-group">
                        <label class="form-label">Date de Naissance</label>
                        <input type="date" name="birth_date" class="form-control" style="padding-left: 14px;" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Classe / Niveau</label>
                        <input type="text" name="class_name" class="form-control" style="padding-left: 14px;" placeholder="Ex: Génie Logiciel 3A" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="cancelAddBtn" style="width: auto;">Annuler</button>
                <button type="submit" class="btn btn-primary" style="width: auto;">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<!-- ================= MODAL MODIFICATION ETUDIANT ================= -->
<div class="modal-overlay" id="editModal">
    <div class="modal-card">
        <div class="modal-header">
            <h3 class="modal-title"><i class="fas fa-user-edit"></i> Modifier l'Étudiant</h3>
            <button class="modal-close" id="closeEditModalBtn"><i class="fas fa-times"></i></button>
        </div>
        <form id="editForm">
            <input type="hidden" name="id">
            
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Identifiant Unique</label>
                    <div class="id-input-group">
                        <input type="text" name="student_id" class="form-control" style="padding-left: 14px;" required>
                        <button type="button" class="btn btn-secondary" id="generateEditIdBtn" title="Générer un ID automatiquement">
                            <i class="fas fa-magic"></i>
                        </button>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div class="form-group">
                        <label class="form-label">Prénom</label>
                        <input type="text" name="first_name" class="form-control" style="padding-left: 14px;" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nom</label>
                        <input type="text" name="last_name" class="form-control" style="padding-left: 14px;" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Adresse Email</label>
                    <input type="email" name="email" class="form-control" style="padding-left: 14px;" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Téléphone</label>
                    <input type="tel" name="phone" class="form-control" style="padding-left: 14px;">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div class="form-group">
                        <label class="form-label">Date de Naissance</label>
                        <input type="date" name="birth_date" class="form-control" style="padding-left: 14px;" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Classe / Niveau</label>
                        <input type="text" name="class_name" class="form-control" style="padding-left: 14px;" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="cancelEditBtn" style="width: auto;">Annuler</button>
                <button type="submit" class="btn btn-primary" style="width: auto;">Enregistrer les modifications</button>
            </div>
        </form>
    </div>
</div>

<!-- Modale Paramètres Profil Admin -->
<div class="modal-overlay" id="adminProfileModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Paramètres Profil Administrateur</h2>
            <button class="modal-close" id="closeProfileBtn"><i class="fas fa-times"></i></button>
        </div>
        <form id="adminProfileForm">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nom complet</label>
                    <input type="text" name="name" id="adminProfileName" class="form-control" style="padding-left: 14px;" value="<?= htmlspecialchars($admin_name ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Identifiant de connexion (Username)</label>
                    <input type="text" name="username" id="adminProfileUsername" class="form-control" style="padding-left: 14px;" value="<?= htmlspecialchars($_SESSION['admin_username'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Nouveau mot de passe (Laissez vide pour ne pas changer)</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock" aria-hidden="true" style="color:var(--text-muted);left:14px;top:50%;transform:translateY(-50%);position:absolute;"></i>
                        <input type="password" id="profilePassword" name="password" class="form-control" style="padding-left: 42px;" placeholder="••••••••">
                        <span class="pw-toggle" id="profilePwToggle" role="button" tabindex="0" style="position:absolute; right:14px; top:50%; transform:translateY(-50%); cursor:pointer; color:var(--text-muted);">
                            <i class="fas fa-eye" id="profilePwIcon" style="position:relative;left:auto;top:auto;transform:none;color:inherit;pointer-events:none;"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="cancelProfileBtn" style="width: auto;">Annuler</button>
                <button type="submit" class="btn btn-primary" style="width: auto;">Enregistrer les modifications</button>
            </div>
        </form>
    </div>
</div>

<!-- Conteneur des toasts (notifications) -->
<div class="toast-container" id="toastContainer"></div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
