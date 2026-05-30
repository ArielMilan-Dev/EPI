<!-- ═══════════ FOOTER ═══════════ -->
<footer class="site-footer" role="contentinfo">
    <div class="container">
        <div class="footer-grid">

            <!-- Col 1 : Marque -->
            <div>
                <div class="footer-brand-name">
                    <img src="public/images/logoepi.png" alt="Logo EPI" style="width:42px;height:42px;border-radius:50%;object-fit:cover;">
                    EPI Yamoussoukro
                </div>
                <p class="footer-brand-desc">
                    École Polytechnique Internationale de Yamoussoukro — 19 filières industrielles
                    et tertiaires pour former les professionnels de Côte d'Ivoire et d'Afrique.
                </p>
                <div class="footer-socials">
                    <a href="#" class="social-btn" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-btn" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="social-btn" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-btn" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <!-- Col 2 : Navigation -->
            <div>
                <p class="footer-col-title">Navigation</p>
                <nav class="footer-nav" aria-label="Navigation footer">
                    <a href="index.php?action=home"><i class="fas fa-chevron-right"></i> Accueil</a>
                    <a href="index.php?action=formations"><i class="fas fa-chevron-right"></i> Nos Formations</a>
                    <a href="index.php?action=contact"><i class="fas fa-chevron-right"></i> Contact</a>
                    <a href="index.php?action=student_login"><i class="fas fa-chevron-right"></i> Espace Étudiant</a>
                    <a href="index.php?action=login"><i class="fas fa-chevron-right"></i> Administration</a>
                </nav>
            </div>

            <!-- Col 3 : Formations -->
            <div>
                <p class="footer-col-title">Filières Phares</p>
                <nav class="footer-nav" aria-label="Formations footer">
                    <a href="index.php?action=formations"><i class="fas fa-chevron-right"></i> Génie Civil</a>
                    <a href="index.php?action=formations"><i class="fas fa-chevron-right"></i> Mines & Pétrole</a>
                    <a href="index.php?action=formations"><i class="fas fa-chevron-right"></i> Informatique</a>
                    <a href="index.php?action=formations"><i class="fas fa-chevron-right"></i> Finance & Compta</a>
                    <a href="index.php?action=formations"><i class="fas fa-chevron-right"></i> Logistique</a>
                </nav>
            </div>

            <!-- Col 4 : Contact -->
            <div>
                <p class="footer-col-title">Nous Contacter</p>
                <div class="footer-contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Yamoussoukro, Côte d'Ivoire</span>
                </div>
                <div class="footer-contact-item">
                    <i class="fas fa-phone"></i>
                    <span>+225 27 30 65 86 22<br>+225 07 57 77 97 78<br>+225 01 70 94 94 70</span>
                </div>
                <div class="footer-contact-item">
                    <i class="fas fa-envelope"></i>
                    <span>epiyamoussoukro@gmail.com</span>
                </div>
                <div class="footer-contact-item">
                    <i class="fas fa-clock"></i>
                    <span>Lun – Ven : 7h30 – 17h00</span>
                </div>
            </div>

        </div><!-- /footer-grid -->

        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> EPI — École Polytechnique Internationale. Tous droits réservés.</p>
            <p>Conçu avec <i class="fas fa-heart" style="color:var(--accent)"></i> pour l'excellence académique</p>
        </div>
    </div>
</footer>

<!-- Scroll-reveal animations -->
<script>
(function () {
    const elems = document.querySelectorAll('.anim');
    if (!elems.length) return;
    const obs = new IntersectionObserver(
        function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) {
                    e.target.classList.add('visible');
                    obs.unobserve(e.target);
                }
            });
        },
        { threshold: 0.12 }
    );
    elems.forEach(function (el) { obs.observe(el); });
})();
</script>

</body>
</html>
