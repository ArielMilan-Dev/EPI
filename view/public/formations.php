<?php
$pageTitle = "Nos Formations — EPI Yamoussoukro";
require_once __DIR__ . '/../layout/public_header.php';

/* ── Vraies filières EPI ─────────────────────────────────── */
$industrielles = [
    [
        'icon'     => 'fas fa-hard-hat',
        'title'    => 'Génie Civil — Option Travaux Publics',
        'sub'      => 'Routes, ponts, barrages et infrastructures publiques. Formation aux techniques de construction des grands ouvrages.',
        'duration' => '2 ans (BTS)',
        'degree'   => 'BTS',
        'skills'   => ['AutoCAD', 'Béton armé', 'Topographie', 'VRD', 'Études de sol', 'Métrés'],
        'careers'  => 'Conducteur de travaux, Ingénieur TP, Chef de chantier',
    ],
    [
        'icon'     => 'fas fa-building',
        'title'    => 'Génie Civil — Option Bâtiment',
        'sub'      => 'Construction, rénovation et gestion de projets de bâtiments résidentiels et commerciaux.',
        'duration' => '2 ans (BTS)',
        'degree'   => 'BTS',
        'skills'   => ['Plans architecturaux', 'Béton', 'Charpente', 'Plomberie', 'Électricité bâtiment', 'Devis'],
        'careers'  => 'Conducteur de travaux bâtiment, Métreur, Chef de chantier',
    ],
    [
        'icon'     => 'fas fa-map-marked-alt',
        'title'    => 'Génie Civil — Option Géomètre Topographe',
        'sub'      => 'Mesure, levé et représentation du terrain. Indispensable pour tout projet d\'aménagement du territoire.',
        'duration' => '2 ans (BTS)',
        'degree'   => 'BTS',
        'skills'   => ['Levés topographiques', 'GPS', 'SIG', 'DAO', 'Cadastre', 'Drone'],
        'careers'  => 'Géomètre-expert, Topographe, Chargé de cadastre',
    ],
    [
        'icon'     => 'fas fa-mountain',
        'title'    => 'Mines Géologie et Pétrole',
        'sub'      => 'Exploration, exploitation et gestion des ressources minières et pétrolières en Afrique.',
        'duration' => '2 ans (BTS)',
        'degree'   => 'BTS',
        'skills'   => ['Géologie', 'Forage', 'Sismologie', 'Pétrophysique', 'Sécurité mine', 'GIS'],
        'careers'  => 'Technicien géologue, Agent pétrolier, Ingénieur mines',
    ],
    [
        'icon'     => 'fas fa-bolt',
        'title'    => 'Électrotechnique',
        'sub'      => 'Production, transport et distribution de l\'énergie électrique. Maintenance des équipements industriels.',
        'duration' => '2 ans (BTS)',
        'degree'   => 'BTS',
        'skills'   => ['Électrotechnique', 'Automatisme', 'Variateurs', 'Câblage', 'Habilitation élec.', 'PLC'],
        'careers'  => 'Électrotechnicien, Technicien de maintenance, Chargé d\'affaires',
    ],
    [
        'icon'     => 'fas fa-network-wired',
        'title'    => 'Réseaux Informatiques et Télécoms',
        'sub'      => 'Administration des réseaux, sécurité informatique et déploiement des infrastructures télécoms.',
        'duration' => '2 ans (BTS)',
        'degree'   => 'BTS',
        'skills'   => ['Cisco', 'Linux', 'VPN', 'Firewall', 'VOIP', 'Fibre optique', 'CCNA', 'WiFi'],
        'careers'  => 'Admin réseau, Technicien télécoms, Ingénieur systèmes',
    ],
    [
        'icon'     => 'fas fa-cow',
        'title'    => 'Agriculture Tropicale — Option Production Animale',
        'sub'      => 'Élevage tropical, nutrition animale et gestion des exploitations pastorales en zone tropicale.',
        'duration' => '2 ans (BTS)',
        'degree'   => 'BTS',
        'skills'   => ['Zootechnie', 'Santé animale', 'Nutrition', 'Gestion d\'élevage', 'Aviculture', 'Pisciculture'],
        'careers'  => 'Technicien d\'élevage, Conseiller agricole, Gérant de ferme',
    ],
    [
        'icon'     => 'fas fa-seedling',
        'title'    => 'Agriculture Tropicale — Option Production Végétale',
        'sub'      => 'Cultures tropicales, agroforesterie et techniques agricoles adaptées aux conditions africaines.',
        'duration' => '2 ans (BTS)',
        'degree'   => 'BTS',
        'skills'   => ['Agronomie', 'Phytopathologie', 'Irrigation', 'Semences', 'Agroforesterie', 'Pesticides'],
        'careers'  => 'Technicien agricole, Chef d\'exploitation, Conseiller rural',
    ],
    [
        'icon'     => 'fas fa-leaf',
        'title'    => 'Gestion de l\'Environnement et des Ressources Naturelles',
        'sub'      => 'Protection de l\'environnement, gestion des ressources naturelles et développement durable en Afrique.',
        'duration' => '2 ans (BTS)',
        'degree'   => 'BTS',
        'skills'   => ['Écologie', 'SIG', 'Évaluation d\'impact', 'Reboisement', 'Eau & assainissement', 'RSE'],
        'careers'  => 'Technicien environnement, Agent forestier, Chargé RSE',
    ],
    [
        'icon'     => 'fas fa-tools',
        'title'    => 'Maintenance des Systèmes de Production',
        'sub'      => 'Entretien, réparation et optimisation des machines et équipements industriels de production.',
        'duration' => '2 ans (BTS)',
        'degree'   => 'BTS',
        'skills'   => ['Mécanique industrielle', 'Pneumatique', 'Hydraulique', 'GMAO', 'TPM', 'Automates'],
        'careers'  => 'Technicien de maintenance, Responsable maintenance, Agent fiabilité',
    ],
    [
        'icon'     => 'fas fa-laptop-code',
        'title'    => 'Informatique — Développeur d\'Application',
        'sub'      => 'Conception et développement d\'applications web, mobiles et logicielles adaptées aux besoins des entreprises.',
        'duration' => '2 ans (BTS)',
        'degree'   => 'BTS',
        'skills'   => ['Python', 'Java', 'PHP', 'JavaScript', 'SQL', 'Android', 'Git', 'UML'],
        'careers'  => 'Développeur web/mobile, Analyste programmeur, Chef de projet IT',
    ],
    [
        'icon'     => 'fas fa-car-side',
        'title'    => 'Moteur et Mécanique Automobile',
        'sub'      => 'Diagnostic, réparation et entretien des véhicules modernes : motorisations thermiques, hybrides et électriques.',
        'duration' => '2 ans (BTS)',
        'degree'   => 'BTS',
        'skills'   => ['Mécanique moteur', 'Électronique auto', 'Diagnostic OBD', 'Carrosserie', 'Boîte auto', 'Climatisation'],
        'careers'  => 'Technicien automobile, Chef d\'atelier, Responsable SAV',
    ],
    [
        'icon'     => 'fas fa-fire',
        'title'    => 'Génie Énergétique et Environnement',
        'sub'      => 'Maîtrise de l\'énergie, énergies renouvelables et systèmes de climatisation et de réfrigération industrielle.',
        'duration' => '2 ans (BTS)',
        'degree'   => 'BTS',
        'skills'   => ['Thermodynamique', 'Solaire PV', 'Froid industriel', 'Audit énergétique', 'CVC', 'Biomasse'],
        'careers'  => 'Technicien énergie, Auditeur énergétique, Installateur ENR',
    ],
];

$tertiaires = [
    [
        'icon'     => 'fas fa-chart-line',
        'title'    => 'Finance Comptabilité et Gestion des Entreprises',
        'sub'      => 'Comptabilité générale, gestion financière, fiscalité et pilotage de la performance des entreprises.',
        'duration' => '2 ans (BTS)',
        'degree'   => 'BTS',
        'skills'   => ['Comptabilité', 'Fiscalité', 'Contrôle de gestion', 'Sage', 'Audit', 'Finance d\'entreprise'],
        'careers'  => 'Comptable, Contrôleur de gestion, Responsable financier',
    ],
    [
        'icon'     => 'fas fa-store',
        'title'    => 'Gestion Commerciale',
        'sub'      => 'Techniques de vente, marketing, gestion des stocks et développement commercial sur le marché africain.',
        'duration' => '2 ans (BTS)',
        'degree'   => 'BTS',
        'skills'   => ['Marketing', 'Négociation', 'CRM', 'E-commerce', 'Gestion stocks', 'Communication'],
        'careers'  => 'Commercial, Chef de rayon, Responsable des ventes, Key Account',
    ],
    [
        'icon'     => 'fas fa-users',
        'title'    => 'Ressources Humaines et Communication',
        'sub'      => 'Gestion du capital humain, recrutement, formation, paie et communication interne et externe.',
        'duration' => '2 ans (BTS)',
        'degree'   => 'BTS',
        'skills'   => ['Droit social', 'Paie', 'Recrutement', 'SIRH', 'Communication', 'Gestion des talents'],
        'careers'  => 'Chargé RH, Responsable paie, Chargé de communication',
    ],
    [
        'icon'     => 'fas fa-truck',
        'title'    => 'Logistique',
        'sub'      => 'Gestion de la chaîne d\'approvisionnement, transport, entreposage et optimisation des flux logistiques.',
        'duration' => '2 ans (BTS)',
        'degree'   => 'BTS',
        'skills'   => ['Supply Chain', 'Transport', 'Douane', 'WMS', 'INCOTERMS', 'Gestion des stocks'],
        'careers'  => 'Logisticien, Transit, Gestionnaire de stocks, Responsable entrepôt',
    ],
    [
        'icon'     => 'fas fa-hotel',
        'title'    => 'Tourisme Hôtellerie',
        'sub'      => 'Accueil, gestion hôtelière, organisation de séjours et développement de l\'industrie touristique.',
        'duration' => '2 ans (BTS)',
        'degree'   => 'BTS',
        'skills'   => ['Accueil', 'Revenue management', 'F&B', 'Événementiel', 'Langue', 'PMS'],
        'careers'  => 'Réceptionniste, Gouvernant(e), Chef de réception, Guide touristique',
    ],
    [
        'icon'     => 'fas fa-briefcase',
        'title'    => 'Assistanat de Direction',
        'sub'      => 'Assistance de haut niveau aux dirigeants : gestion de l\'agenda, communication, organisation et coordination.',
        'duration' => '2 ans (BTS)',
        'degree'   => 'BTS',
        'skills'   => ['Bureautique', 'Rédaction professionnelle', 'Organisation', 'Anglais', 'Agenda', 'Protocole'],
        'careers'  => 'Assistant(e) de direction, Office manager, Secrétaire général(e)',
    ],
];
?>

<main id="main-content">

<!-- ═══════════ PAGE HERO ═══════════ -->
<section class="page-hero" aria-label="En-tête formations">
    <div class="hero-grid" aria-hidden="true"></div>
    <div class="container page-hero-content">
        <div class="hero-badge anim">
            <i class="fas fa-book-open" aria-hidden="true"></i> Catalogue des formations
        </div>
        <h1 class="page-hero-title anim anim-d1">Nos Filières</h1>
        <p class="page-hero-sub anim anim-d2">
            <?= count($industrielles) + count($tertiaires) ?> filières professionnelles réparties en deux pôles :
            <strong style="color:var(--accent-light)">Industriel</strong> et
            <strong style="color:var(--accent-light)">Tertiaire</strong>.
            Des formations BTS tournées vers l'excellence et l'employabilité en Côte d'Ivoire et en Afrique.
        </p>
    </div>
</section>

<!-- ═══════════ FILIÈRES INDUSTRIELLES ═══════════ -->
<section class="formations-section" style="background:var(--bg-light);" aria-labelledby="ind-heading">
    <div class="container">

        <header class="section-header">
            <div class="section-tag anim" style="background:rgba(26,43,94,.1);color:var(--primary);">
                <i class="fas fa-industry"></i> Filières Industrielles
            </div>
            <h2 class="section-title anim anim-d1" id="ind-heading">Pôle Industriel</h2>
            <p class="section-sub anim anim-d2">
                <?= count($industrielles) ?> filières techniques et industrielles pour former les bâtisseurs
                et ingénieurs de terrain de demain.
            </p>
        </header>

        <div class="formations-grid">
            <?php foreach ($industrielles as $i => $f): ?>
            <article class="formation-card anim anim-d<?= ($i % 3) + 1 ?>">
                <div class="formation-card-banner" style="background:var(--grad-hero);"></div>
                <div class="formation-card-body">
                    <div class="formation-icon" aria-hidden="true">
                        <i class="<?= $f['icon'] ?>"></i>
                    </div>
                    <h3 class="formation-title"><?= htmlspecialchars($f['title']) ?></h3>
                    <p class="formation-sub"><?= htmlspecialchars($f['sub']) ?></p>
                    <div class="formation-specs">
                        <div class="spec-item">
                            <div class="spec-lbl">Durée</div>
                            <div class="spec-val"><?= htmlspecialchars($f['duration']) ?></div>
                        </div>
                        <div class="spec-item">
                            <div class="spec-lbl">Diplôme</div>
                            <div class="spec-val"><?= htmlspecialchars($f['degree']) ?></div>
                        </div>
                        <div class="spec-item" style="grid-column:1/-1">
                            <div class="spec-lbl">Débouchés</div>
                            <div class="spec-val" style="font-size:13px;font-weight:500;color:var(--text-muted)">
                                <?= htmlspecialchars($f['careers']) ?>
                            </div>
                        </div>
                    </div>
                    <div class="formation-skills">
                        <?php foreach ($f['skills'] as $s): ?>
                            <span class="skill-tag"><?= htmlspecialchars($s) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════ FILIÈRES TERTIAIRES ═══════════ -->
<section class="formations-section" style="background:var(--bg-white);" aria-labelledby="ter-heading">
    <div class="container">

        <header class="section-header">
            <div class="section-tag anim">
                <i class="fas fa-briefcase"></i> Filières Tertiaires
            </div>
            <h2 class="section-title anim anim-d1" id="ter-heading">Pôle Tertiaire</h2>
            <p class="section-sub anim anim-d2">
                <?= count($tertiaires) ?> filières dans le commerce, la gestion et les services
                pour alimenter le secteur économique de la Côte d'Ivoire.
            </p>
        </header>

        <div class="formations-grid">
            <?php foreach ($tertiaires as $i => $f): ?>
            <article class="formation-card anim anim-d<?= ($i % 3) + 1 ?>">
                <div class="formation-card-banner"></div>
                <div class="formation-card-body">
                    <div class="formation-icon" aria-hidden="true">
                        <i class="<?= $f['icon'] ?>"></i>
                    </div>
                    <h3 class="formation-title"><?= htmlspecialchars($f['title']) ?></h3>
                    <p class="formation-sub"><?= htmlspecialchars($f['sub']) ?></p>
                    <div class="formation-specs">
                        <div class="spec-item">
                            <div class="spec-lbl">Durée</div>
                            <div class="spec-val"><?= htmlspecialchars($f['duration']) ?></div>
                        </div>
                        <div class="spec-item">
                            <div class="spec-lbl">Diplôme</div>
                            <div class="spec-val"><?= htmlspecialchars($f['degree']) ?></div>
                        </div>
                        <div class="spec-item" style="grid-column:1/-1">
                            <div class="spec-lbl">Débouchés</div>
                            <div class="spec-val" style="font-size:13px;font-weight:500;color:var(--text-muted)">
                                <?= htmlspecialchars($f['careers']) ?>
                            </div>
                        </div>
                    </div>
                    <div class="formation-skills">
                        <?php foreach ($f['skills'] as $s): ?>
                            <span class="skill-tag">
                                <?= htmlspecialchars($s) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════ CTA ═══════════ -->
<section class="cta-section" aria-label="Inscription">
    <div class="hero-grid" aria-hidden="true"></div>
    <div class="container cta-content">
        <h2 class="cta-title anim">Votre filière vous attend à l'EPI</h2>
        <p class="cta-sub anim anim-d1">
            Créez votre espace étudiant et rejoignez l'une de nos
            <?= count($industrielles) + count($tertiaires) ?> filières professionnelles à Yamoussoukro.
        </p>
        <div class="hero-cta anim anim-d2">
            <a href="index.php?action=student_register" class="btn-hero-primary">
                <i class="fas fa-user-plus"></i> Créer mon compte
            </a>
            <a href="index.php?action=contact" class="btn-hero-ghost">
                <i class="fas fa-envelope"></i> Nous contacter
            </a>
        </div>
    </div>
</section>

</main>

<?php require_once __DIR__ . '/../layout/public_footer.php'; ?>
