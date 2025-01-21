// Initialisation au chargement du document
document.addEventListener('DOMContentLoaded', () => {
    handleLogoutMessage();
    initMobileNavigation();
    initPasswordValidation();
    initAccountNavigation();
    initBlogEffects();
});

// Gestion du message de déconnexion
function handleLogoutMessage() {
    const urlParams = new URLSearchParams(window.location.search);
    const logoutParam = urlParams.get('logout');
    const logoutMessage = document.getElementById('logout-message');
    
    if (logoutParam === 'success' && logoutMessage) {
        logoutMessage.style.display = 'block';
        setTimeout(() => {
            logoutMessage.style.display = 'none';
            // Nettoie l'URL des paramètres de requête
            window.history.replaceState({}, document.title, window.location.pathname);
        }, 3000);
    }
}

// Gestion du menu mobile améliorée
function initMobileNavigation() {
    const bar = document.getElementById("bar");
    const navbar = document.getElementById("navbar");
    const close = document.getElementById("close");

    if (bar) {
        bar.addEventListener("click", (e) => {
            e.preventDefault();
            navbar.classList.add("active");
        });
    }

    if (close) {
        close.addEventListener("click", (e) => {
            e.preventDefault();
            navbar.classList.remove("active");
        });
    }

    // Fermeture du menu mobile lors du clic sur un lien
    document.querySelectorAll('#navbar a').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 768) {
                navbar.classList.remove("active");
            }
        });
    });

    // Fermeture du menu lors d'un clic en dehors
    document.addEventListener('click', (e) => {
        if (window.innerWidth <= 768 && navbar && bar) {
            if (!navbar.contains(e.target) && 
                !bar.contains(e.target) && 
                navbar.classList.contains('active')) {
                navbar.classList.remove("active");
            }
        }
    });

    // Gestion du redimensionnement de la fenêtre
    window.addEventListener('resize', () => {
        if (window.innerWidth > 768 && navbar.classList.contains('active')) {
            navbar.classList.remove('active');
        }
    });
}

// Validation du mot de passe en temps réel
function initPasswordValidation() {
    const passwordField = document.getElementById('password');
    const passwordRequirements = document.getElementById('password-requirements');
    const requirements = {
        length: { regex: /.{8,}/, element: document.getElementById('length') },
        uppercase: { regex: /[A-Z]/, element: document.getElementById('uppercase') },
        lowercase: { regex: /[a-z]/, element: document.getElementById('lowercase') },
        number: { regex: /[0-9]/, element: document.getElementById('number') },
        special: { regex: /[\W_]/, element: document.getElementById('special') }
    };

    if (passwordField && passwordRequirements) {
        passwordField.addEventListener('focus', () => passwordRequirements.style.display = 'block');
        passwordField.addEventListener('blur', () => passwordRequirements.style.display = 'none');
        
        passwordField.addEventListener('input', () => {
            const password = passwordField.value;
            Object.entries(requirements).forEach(([key, {regex, element}]) => {
                if (element) {
                    const isValid = regex.test(password);
                    element.classList.toggle('valid', isValid);
                    element.classList.toggle('invalid', !isValid);
                }
            });
        });
    }
}

// Navigation du compte utilisateur
function initAccountNavigation() {
    document.querySelectorAll('[data-account-link]').forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const checkLoginPath = window.location.pathname.includes('/account/') 
                ? 'check_login.php' 
                : '/account/check_login.php';
            
            fetch(checkLoginPath)
                .then(response => response.json())
                .then(data => {
                    window.location.href = data.redirectUrl;
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    window.location.href = '/account/connexion.php';
                });
        });
    });
}

// Gestion de la visibilité du mot de passe
function togglePasswordVisibility(inputId = 'password', iconId = 'togglePasswordIcon') {
    const passwordInput = document.getElementById(inputId);
    const toggleIcon = document.getElementById(iconId);
    
    if (passwordInput && toggleIcon) {
        const isVisible = passwordInput.type === 'text';
        passwordInput.type = isVisible ? 'password' : 'text';
        toggleIcon.classList.toggle('fa-eye', isVisible);
        toggleIcon.classList.toggle('fa-eye-slash', !isVisible);
    }
}

// Effets visuels pour le blog
function initBlogEffects() {
    // Gestion des effets de survol
    const contentBoxes = document.querySelectorAll(
        '.saveur-box, .variete-box, .preparation-box, .torrefaction-box, .country-card'
    );
    
    contentBoxes.forEach(box => {
        box.addEventListener('mouseenter', (e) => {
            e.target.style.transform = 'scale(1.02)';
            e.target.style.boxShadow = '0 4px 8px rgba(88, 47, 27, 0.2)';
            e.target.style.transition = 'transform 0.2s ease, box-shadow 0.2s ease';
        });

        box.addEventListener('mouseleave', (e) => {
            e.target.style.transform = 'scale(1)';
            e.target.style.boxShadow = 'none';
        });

        box.addEventListener('mouseover', (e) => {
            e.target.style.backgroundColor = 'rgba(98, 128, 93, 0.05)';
        });

        box.addEventListener('mouseout', (e) => {
            e.target.style.backgroundColor = 'transparent';
        });
    });

    // Animation d'apparition au défilement
    const sections = document.querySelectorAll('.conseils-card, .article-section');
    
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };

    const sectionObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    sections.forEach(section => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(20px)';
        section.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        sectionObserver.observe(section);
    });
}

// Export des fonctions pour utilisation externe
window.togglePasswordVisibility = togglePasswordVisibility;