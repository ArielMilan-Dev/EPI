<?php
$pageTitle = "Contact — EPI";
require_once __DIR__ . '/../layout/public_header.php';
?>

<main id="main-content">

<!-- ═══════════ PAGE HERO ═══════════ -->
<section class="page-hero" aria-label="En-tête contact">
    <div class="hero-grid" aria-hidden="true"></div>
    <div class="container page-hero-content">
        <div class="hero-badge anim">
            <i class="fas fa-envelope" aria-hidden="true"></i> Contactez-nous
        </div>
        <h1 class="page-hero-title anim anim-d1">Parlons-en</h1>
        <p class="page-hero-sub anim anim-d2">
            Une question sur nos formations, une demande d'information ou
            simplement envie d'en savoir plus ? Notre équipe vous répond sous 48h.
        </p>
    </div>
</section>

<!-- ═══════════ CONTACT SECTION ═══════════ -->
<section class="contact-section" aria-labelledby="contact-heading">
    <div class="container">
        <div class="contact-grid">

            <!-- Infos -->
            <div>
                <h2 class="contact-info-title anim" id="contact-heading">
                    Nous sommes<br>à votre écoute
                </h2>
                <p class="contact-info-sub anim anim-d1">
                    Que vous soyez lycéen, étudiant en reconversion ou professionnel,
                    nos conseillers sont disponibles pour vous guider vers la formation
                    qui correspond à vos ambitions.
                </p>

                <div class="contact-item anim anim-d1">
                    <div class="contact-icon" aria-hidden="true">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <div class="contact-item-lbl">Adresse</div>
                        <div class="contact-item-val">
                            Quartier Millionaire, Campus EPI<br>
                            Yamoussoukro — Côte d'Ivoire
                        </div>
                    </div>
                </div>

                <div class="contact-item anim anim-d2">
                    <div class="contact-icon" aria-hidden="true">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div>
                        <div class="contact-item-lbl">Téléphone</div>
                        <div class="contact-item-val">
                            +225 27 30 65 86 22<br>
                            +225 07 57 77 97 78<br>
                            +225 01 70 94 94 70
                        </div>
                    </div>
                </div>

                <div class="contact-item anim anim-d3">
                    <div class="contact-icon" aria-hidden="true">
                        <i class="fas fa-envelope-open-text"></i>
                    </div>
                    <div>
                        <div class="contact-item-lbl">Email</div>
                        <div class="contact-item-val">epiyamoussoukro@gmail.com</div>
                    </div>
                </div>

                <div class="contact-item anim anim-d4">
                    <div class="contact-icon" aria-hidden="true">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <div class="contact-item-lbl">Horaires</div>
                        <div class="contact-item-val">
                            Lundi – Samedi : 8h00 – 18h00<br>
                            Samedi : 9h00 – 12h30
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulaire -->
            <div class="anim anim-d2">
                <div class="contact-form-card">
                    <h3 class="contact-form-title">Envoyer un message</h3>

                    <?php if (!empty($error)): ?>
                        <div class="alert alert-error" role="alert">
                            <i class="fas fa-exclamation-circle"></i>
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success" role="alert" style="margin-bottom:0;">
                            <i class="fas fa-check-circle"></i>
                            <?= htmlspecialchars($success) ?>
                        </div>
                    <?php else: ?>

                    <form method="POST" action="index.php?action=contact" class="contact-form" novalidate id="contactForm">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="cname">Nom complet <span style="color:var(--accent)">*</span></label>
                                <input
                                    type="text"
                                    id="cname"
                                    name="name"
                                    class="contact-input"
                                    placeholder="Votre nom"
                                    required
                                    value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                                >
                            </div>
                            <div class="form-group">
                                <label for="cemail">Adresse email <span style="color:var(--accent)">*</span></label>
                                <input
                                    type="email"
                                    id="cemail"
                                    name="email"
                                    class="contact-input"
                                    placeholder="vous@exemple.com"
                                    required
                                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                                >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="csubject">Sujet <span style="color:var(--accent)">*</span></label>
                            <input
                                type="text"
                                id="csubject"
                                name="subject"
                                class="contact-input"
                                placeholder="Objet de votre message"
                                required
                                value="<?= htmlspecialchars($_POST['subject'] ?? '') ?>"
                            >
                        </div>

                        <div class="form-group">
                            <label for="cmessage">Message <span style="color:var(--accent)">*</span></label>
                            <textarea
                                id="cmessage"
                                name="message"
                                class="contact-input"
                                rows="6"
                                placeholder="Décrivez votre demande en détail..."
                                required
                            ><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
                        </div>

                        <button type="submit" class="btn-contact" id="contactSubmitBtn">
                            <i class="fas fa-paper-plane"></i>
                            Envoyer le message
                        </button>
                    </form>

                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</section>

</main>

<?php require_once __DIR__ . '/../layout/public_footer.php'; ?>
