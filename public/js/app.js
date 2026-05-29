document.addEventListener('DOMContentLoaded', () => {
    // --- INITIALISATION DES VARIABLES ET DOM ---
    const searchInput = document.getElementById('searchInput');
    const classFilter = document.getElementById('classFilter');
    const studentTableBody = document.getElementById('studentTableBody');
    const toastContainer = document.getElementById('toastContainer');
    
    // Stats elements
    const statTotal = document.getElementById('statTotal');
    const statClasses = document.getElementById('statClasses');
    const statNew = document.getElementById('statNew');

    // Modals
    const addModal = document.getElementById('addModal');
    const editModal = document.getElementById('editModal');
    
    // Forms
    const addForm = document.getElementById('addForm');
    const editForm = document.getElementById('editForm');

    // Action buttons that trigger modals
    const openAddModalBtn = document.getElementById('openAddModalBtn');
    const closeAddModalBtn = document.getElementById('closeAddModalBtn');
    const cancelAddBtn = document.getElementById('cancelAddBtn');
    const closeEditModalBtn = document.getElementById('closeEditModalBtn');
    const cancelEditBtn = document.getElementById('cancelEditBtn');

    // Helper buttons for auto-generating IDs
    const generateAddIdBtn = document.getElementById('generateAddIdBtn');
    const generateEditIdBtn = document.getElementById('generateEditIdBtn');

    // --- CONTROLES DE LA SESSION ET REDIRECTION AJAX ---
    const handleAjaxError = (response) => {
        if (!response.success && response.message && response.message.includes('Session expirée')) {
            showToast(response.message, 'error');
            setTimeout(() => {
                window.location.href = 'index.php?action=login';
            }, 1500);
            return true;
        }
        return false;
    };

    // --- SYSTEME DE THÈME (DARK / LIGHT MODE) ---
    const themeToggleBtn = document.getElementById('themeToggleBtn');
    if (themeToggleBtn) {
        themeToggleBtn.addEventListener('click', () => {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            
            // Mettre à jour l'icône du bouton
            const icon = themeToggleBtn.querySelector('i');
            if (icon) {
                icon.className = newTheme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
            }
        });
    }

    // --- SYSTEME DE NOTIFICATIONS (TOASTS) ---
    window.showToast = function(message, type = 'success') {
        if (!toastContainer) return;
        
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        
        const iconClass = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';
        
        toast.innerHTML = `
            <div class="toast-content">
                <i class="${iconClass} toast-icon"></i>
                <span class="toast-text">${message}</span>
            </div>
            <button class="toast-close"><i class="fas fa-times"></i></button>
        `;
        
        toastContainer.appendChild(toast);
        
        // Gérer la fermeture manuelle
        const closeBtn = toast.querySelector('.toast-close');
        closeBtn.addEventListener('click', () => {
            removeToast(toast);
        });
        
        // Gérer l'auto-destruction
        setTimeout(() => {
            removeToast(toast);
        }, 4000);
    };

    function removeToast(toast) {
        toast.style.transform = 'translateX(120%)';
        toast.style.opacity = '0';
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 300);
    }

    // --- GENERATEUR D'IDENTIFIANTS ETUDIANT ---
    function generateStudentId() {
        const year = new Date().getFullYear();
        const rand = Math.floor(1000 + Math.random() * 9000); // 4 chiffres aléatoires
        return `EPI-${year}-${rand}`;
    }

    if (generateAddIdBtn) {
        generateAddIdBtn.addEventListener('click', () => {
            const idInput = addForm.querySelector('[name="student_id"]');
            if (idInput) {
                idInput.value = generateStudentId();
                showToast("Identifiant unique généré avec succès.", "success");
            }
        });
    }

    if (generateEditIdBtn) {
        generateEditIdBtn.addEventListener('click', () => {
            const idInput = editForm.querySelector('[name="student_id"]');
            if (idInput) {
                idInput.value = generateStudentId();
                showToast("Identifiant unique généré avec succès.", "success");
            }
        });
    }

    // --- OUVERTURE / FERMETURE DES MODALS ---
    function openModal(modal) {
        if (!modal) return;
        modal.classList.add('active');
        document.body.style.overflow = 'hidden'; // Empêcher le défilement de la page arrière
    }

    function closeModal(modal) {
        if (!modal) return;
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }

    if (openAddModalBtn) {
        openAddModalBtn.addEventListener('click', () => {
            addForm.reset();
            // Générer automatiquement un ID par défaut
            addForm.querySelector('[name="student_id"]').value = generateStudentId();
            openModal(addModal);
        });
    }

    if (closeAddModalBtn) closeAddModalBtn.addEventListener('click', () => closeModal(addModal));
    if (cancelAddBtn) cancelAddBtn.addEventListener('click', () => closeModal(addModal));
    if (closeEditModalBtn) closeEditModalBtn.addEventListener('click', () => closeModal(editModal));
    if (cancelEditBtn) cancelEditBtn.addEventListener('click', () => closeModal(editModal));

    // Fermeture en cliquant en dehors du modal
    [addModal, editModal].forEach(modal => {
        if (modal) {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    closeModal(modal);
                }
            });
        }
    });

    // --- CHARGEMENT DYNAMIQUE DES ETUDIANTS (AJAX - LIST) ---
    let searchTimeout = null;

    function loadStudents() {
        if (!studentTableBody) return;
        
        const query = searchInput ? encodeURIComponent(searchInput.value) : '';
        const filter = classFilter ? encodeURIComponent(classFilter.value) : '';
        
        // Afficher l'indicateur de chargement
        studentTableBody.innerHTML = `
            <tr>
                <td colspan="7">
                    <div class="table-loading-overlay">
                        <div class="spinner"></div>
                    </div>
                </td>
            </tr>
        `;

        fetch(`index.php?action=ajax_list&search=${query}&class_name=${filter}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
            if (handleAjaxError(data)) return;

            if (data.success) {
                // Mise à jour des statistiques
                if (statTotal) statTotal.textContent = data.stats.total_students;
                if (statClasses) statClasses.textContent = data.stats.total_classes;
                if (statNew) statNew.textContent = data.stats.new_enrollments;

                // Mise à jour des filtres (si nécessaire, pour garder la liste des classes dynamique)
                updateFilterDropdown(data.classes, filter);

                // Remplir le tableau
                if (data.students.length === 0) {
                    studentTableBody.innerHTML = `
                        <tr>
                            <td colspan="7">
                                <div class="table-empty-state">
                                    <i class="fas fa-user-slash"></i>
                                    <p>Aucun étudiant trouvé correspondant aux critères.</p>
                                </div>
                            </td>
                        </tr>
                    `;
                    return;
                }

                let rowsHtml = '';
                data.students.forEach(student => {
                    // Calcul de l'âge à partir de la date de naissance
                    const age = calculateAge(student.birth_date);
                    const formattedDate = formatDate(student.created_at);

                    rowsHtml += `
                        <tr data-id="${student.id}">
                            <td><span class="badge-id">${escapeHtml(student.student_id)}</span></td>
                            <td>
                                <div class="student-identity">
                                    <span class="student-name-text">${escapeHtml(student.first_name)} ${escapeHtml(student.last_name)}</span>
                                    <span class="student-sub">Né(e) le ${escapeHtml(student.birth_date)} (${age} ans)</span>
                                </div>
                            </td>
                            <td>${escapeHtml(student.email)}</td>
                            <td>${escapeHtml(student.phone || '-')}</td>
                            <td><span class="badge-class">${escapeHtml(student.class_name)}</span></td>
                            <td class="student-sub">${formattedDate}</td>
                            <td>
                                <div class="actions-cell">
                                    <button class="btn-icon btn-edit" data-id="${student.id}" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-icon btn-icon-danger btn-delete" data-id="${student.id}" title="Supprimer">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `;
                });
                studentTableBody.innerHTML = rowsHtml;

                // Attacher les gestionnaires d'événements sur les boutons Modifier/Supprimer
                attachRowActions();
            } else {
                showToast(data.message || "Erreur de chargement des données.", "error");
            }
        })
        .catch(err => {
            console.error(err);
            showToast("Erreur de connexion avec le serveur.", "error");
        });
    }

    // Mettre à jour la liste déroulante des classes sans casser la sélection actuelle
    function updateFilterDropdown(classes, currentSelectedValue) {
        if (!classFilter) return;
        
        // On conserve la première option ("Toutes les classes")
        let optionsHtml = '<option value="">Toutes les classes</option>';
        classes.forEach(cls => {
            const isSelected = cls === currentSelectedValue ? 'selected' : '';
            optionsHtml += `<option value="${escapeHtml(cls)}" ${isSelected}>${escapeHtml(cls)}</option>`;
        });
        classFilter.innerHTML = optionsHtml;
    }

    // Événements de recherche (Débouncé à 300ms)
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(loadStudents, 300);
        });
    }

    // Événements de filtre
    if (classFilter) {
        classFilter.addEventListener('change', loadStudents);
    }

    // --- ACTIONS DE MODIFICATION & SUPPRESSION (DYNAMIQUE) ---
    function attachRowActions() {
        // Boutons modifier
        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.getAttribute('data-id');
                fetch(`index.php?action=ajax_get&id=${id}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => res.json())
                .then(data => {
                    if (handleAjaxError(data)) return;

                    if (data.success) {
                        // Remplir le formulaire
                        const s = data.student;
                        editForm.querySelector('[name="id"]').value = s.id;
                        editForm.querySelector('[name="student_id"]').value = s.student_id;
                        editForm.querySelector('[name="first_name"]').value = s.first_name;
                        editForm.querySelector('[name="last_name"]').value = s.last_name;
                        editForm.querySelector('[name="email"]').value = s.email;
                        editForm.querySelector('[name="phone"]').value = s.phone || '';
                        editForm.querySelector('[name="birth_date"]').value = s.birth_date;
                        editForm.querySelector('[name="class_name"]').value = s.class_name;

                        openModal(editModal);
                    } else {
                        showToast(data.message, "error");
                    }
                })
                .catch(err => {
                    console.error(err);
                    showToast("Impossible de charger les données de l'étudiant.", "error");
                });
            });
        });

        // Boutons supprimer
        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.getAttribute('data-id');
                const row = btn.closest('tr');
                const name = row.querySelector('.student-name-text').textContent;

                if (confirm(`Êtes-vous sûr de vouloir supprimer l'étudiant "${name}" ? Cette action est irréversible.`)) {
                    const formData = new FormData();
                    formData.append('id', id);

                    fetch('index.php?action=ajax_delete', {
                        method: 'POST',
                        body: formData,
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (handleAjaxError(data)) return;

                        if (data.success) {
                            showToast(data.message, "success");
                            // Retirer la ligne avec animation de fondu
                            row.style.transition = 'all 0.3s ease';
                            row.style.opacity = '0';
                            row.style.transform = 'scale(0.95)';
                            setTimeout(loadStudents, 300);
                        } else {
                            showToast(data.message, "error");
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        showToast("Erreur lors de la suppression.", "error");
                    });
                }
            });
        });
    }

    // --- SOUMISSION DES FORMULAIRES VIA AJAX ---
    if (addForm) {
        addForm.addEventListener('submit', (e) => {
            e.preventDefault();

            const formData = new FormData(addForm);
            
            fetch('index.php?action=ajax_add', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                if (handleAjaxError(data)) return;

                if (data.success) {
                    showToast(data.message, "success");
                    closeModal(addModal);
                    addForm.reset();
                    loadStudents();
                } else {
                    showToast(data.message, "error");
                }
            })
            .catch(err => {
                console.error(err);
                showToast("Erreur lors de l'enregistrement.", "error");
            });
        });
    }

    if (editForm) {
        editForm.addEventListener('submit', (e) => {
            e.preventDefault();

            const formData = new FormData(editForm);
            
            fetch('index.php?action=ajax_update', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                if (handleAjaxError(data)) return;

                if (data.success) {
                    showToast(data.message, "success");
                    closeModal(editModal);
                    loadStudents();
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

    // --- FONCTIONS UTILITAIRES ---
    function calculateAge(birthDateString) {
        const today = new Date();
        const birthDate = new Date(birthDateString);
        let age = today.getFullYear() - birthDate.getFullYear();
        const m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        return age;
    }

    function formatDate(dateString) {
        // Formate de YYYY-MM-DD HH:MM:SS à DD/MM/YYYY
        if (!dateString) return '-';
        const parts = dateString.split(' ')[0].split('-');
        if (parts.length !== 3) return dateString;
        return `${parts[2]}/${parts[1]}/${parts[0]}`;
    }

    function escapeHtml(text) {
        if (!text) return '';
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.toString().replace(/[&<>"']/g, function(m) { return map[m]; });
    }

    // Chargement initial des étudiants si nous sommes sur la page du tableau de bord
    if (studentTableBody) {
        loadStudents();
    }
});
