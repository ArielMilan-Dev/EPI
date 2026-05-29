<?php require_once __DIR__ . '/layout/header.php'; ?>

<div class="dashboard-container">
    
    <!-- En-tête du Tableau de Bord -->
    <header class="dash-header">
        <div class="dash-brand">
            <div class="dash-logo">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="dash-brand-info">
                <h1>EPI Scolarité</h1>
                <p>Espace d'Administration</p>
            </div>
        </div>

        <div class="dash-user-panel">
            <!-- Sélecteur de Thème -->
            <button class="theme-toggle-btn" id="themeToggleBtn" title="Changer de thème" style="position: static;">
                <i class="fas fa-moon"></i>
            </button>

            <!-- Badge Utilisateur -->
            <div class="admin-badge">
                <div class="admin-avatar">
                    <?= strtoupper(substr($admin_name ?? 'A', 0, 1)) ?>
                </div>
                <span class="admin-name"><?= htmlspecialchars($admin_name ?? 'Admin') ?></span>
            </div>

            <!-- Bouton Déconnexion -->
            <a href="index.php?action=logout" class="btn btn-secondary btn-sm" style="width: auto;">
                <i class="fas fa-sign-out-alt"></i> Déconnexion
            </a>
        </div>
    </header>

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
    <main class="table-section">
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
    </main>
</div>

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

<!-- Conteneur des toasts (notifications) -->
<div class="toast-container" id="toastContainer"></div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
