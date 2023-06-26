<section id="container">
    <div class="forms-container">
        <div id="signin-signup">
            <form action="ws/login" method="POST" class="sign-in-form" onsubmit="sendFormSignIn(event)">
                <h2 class="title">Connexion</h2>
                <div class="input-box">
                    <i class="fas fa-user"></i>
                    <input type="mail" name="email" id="email" placeholder="Votre mail" required>
                </div>
                <div class="input-box">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="passwordLogin" id="passwordLogin" placeholder="Votre mot de passe" required>
                </div>
                <div class="checkbox-box">
                    <input type="checkbox" name="rememberMe" id="rememberMe">
                    <label for="rememberMe">Se souvenir de moi</label>
                </div>
                <input type="submit" value="Connexion" class="btn solid">
                <p class="social-text">Retrouvez moi sur :</p>
                <div class="social-media">
                    <a href="https://github.com/theomhn/theBigProject" class="social-icon">
                        <i class="fab fa-github"></i>
                    </a>
                    <a href="https://www.linkedin.com/in/theomenchon/" class="social-icon">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="mailto:theo.menchon@hotmail.fr" class="social-icon">
                        <i class="fa-solid fa-envelope"></i>
                    </a>
                </div>
            </form>
            <form action="ws/users" method="POST" class="sign-up-form" onsubmit="sendFormSignUp(event)">
                <h2 class="title">Inscription</h2>
                <div class="input-box">
                    <i class="fas fa-user"></i>
                    <input type="text" name="pseudo" id="pseudo" placeholder="Votre pseudo" required>
                </div>
                <div class="input-box">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" id="email" placeholder="Votre mail" required>
                </div>
                <div class="input-box">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" id="password" placeholder="Votre mot de passe" required>
                </div>
                <div class="input-box">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirmer votre mot de passe" required>
                </div>
                <input type="submit" class="btn" value="Inscription">
                <div id="erreurContainer"></div>

                <p class="social-text">Retrouvez moi sur :</p>
                <div class="social-media">
                    <a href="https://github.com/theomhn/theBigProject" class="social-icon">
                        <i class="fab fa-github"></i>
                    </a>
                    <a href="https://www.linkedin.com/in/theomenchon/" class="social-icon">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="mailto:theo.menchon@hotmail.fr" class="social-icon">
                        <i class="fa-solid fa-envelope"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>
    <div class="panels-container">
        <div class="panel left-panel">
            <div class="content">
                <h3>Pas encore de compte ?</h3>
                <p>Créé en un maintenant, c'est gratuit et rapide !</p>
                <button class="btn transparent" id="sign-up-btn">
                    S'inscrire
                </button>
            </div>
            <img src="public/img/dominus-rl.png" class="image" alt="Dominus rocket league">
        </div>
        <div class="panel right-panel">
            <div class="content">
                <h3>Déjà membre ?</h3>
                <p>Connectez-vous des maintenant !</p>
                <button class="btn transparent" id="sign-in-btn">
                    Se connecter
                </button>
            </div>
            <img src="public/img/merc-rl.webp" class="image" alt="Merc rocket league">
        </div>
    </div>
</section>

<script src="public/script/connexion.js"></script>

<script>
    // Fonction asynchrone pour envoyer le formulaire de connexion
    async function sendFormSignIn(e) {
        event.preventDefault(); // Empêche le comportement par défaut du formulaire
        const form = e.target;
        const formData = new FormData(form); // Crée un nouvel objet FormData à partir du formulaire
        const body = Object.fromEntries(formData.entries()); // Convertit les données du formulaire en un objet

        // Effectue une requête fetch pour envoyer les données du formulaire
        const connexion = await fetch(form.getAttribute('action'), {
            method: form.getAttribute('method'),
            body: JSON.stringify(body)
        })

        if (connexion.ok) {
            window.location.href = 'les-tournois'; // Redirige vers les tournois si la connexion est réussie
        }

        await connexion.json(); // Attend la réponse et la convertit en JSON
    }

    // Fonction asynchrone pour envoyer le formulaire d'inscription
    async function sendFormSignUp(e) {
        event.preventDefault(); // Empêche le comportement par défaut du formulaire
        const form = e.target;
        const formData = new FormData(form); // Crée un nouvel objet FormData à partir du formulaire
        const body = Object.fromEntries(formData.entries()); // Convertit les données du formulaire en un objet

        // Effectue une requête fetch pour envoyer les données du formulaire
        const inscription = await fetch(form.getAttribute('action'), {
            method: form.getAttribute('method'),
            body: JSON.stringify(body)
        })

        const password = document.getElementById("password").value; // Récupère la valeur du champ de mot de passe
        const confirmPassword = document.getElementById("confirmPassword").value; // Récupère la valeur du champ de confirmation de mot de passe
        const erreurContainer = document.getElementById("erreurContainer"); // Récupère l'élément contenant les messages d'erreur

        const paragraph = document.createElement("p"); // Crée un nouvel élément de paragraphe
        const accountValidation = document.createElement("a"); // Crée un nouvel élément d'ancre

        if (inscription.ok) {
            if ((password != confirmPassword)) {
                paragraph.innerHTML = 'Les mots de passe de correspondents pas !'; // Définit le contenu du paragraphe avec un message d'erreur
                erreurContainer.appendChild(paragraph); // Ajoute le paragraphe à l'élément contenant les messages d'erreur
            } else {
                const link = await inscription.json(); // Attend la réponse de la requête et la convertit en JSON

                erreurContainer.innerHTML = '';
                accountValidation.href = link; // Définit l'URL de l'ancre avec le lien renvoyé par la requête
                accountValidation.innerHTML = 'Validez votre compte'; // Définit le texte de l'ancre
                erreurContainer.appendChild(accountValidation); // Ajoute l'ancre à l'élément contenant les messages d'erreur
            }
        } else {
            erreurContainer.innerHTML = '';
            paragraph.innerHTML = 'Un compte existe déjà avec cette adresse mail.'; // Définit le contenu du paragraphe avec un message d'erreur
            erreurContainer.appendChild(paragraph); // Ajoute le paragraphe à l'élément contenant les messages d'erreur
        }
    }
</script>