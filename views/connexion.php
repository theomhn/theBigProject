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
                    <input type="password" name="confirm-password" id="confirm-password" placeholder="Confirmer votre mot de passe" required>
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
    async function sendFormSignIn(e) {
        event.preventDefault();
        const form = e.target;
        const connexion = await fetch(form.getAttribute('action'), {
            method: form.getAttribute('method'),
            body: new FormData(form)
        })
        if (connexion.ok) {
            window.location.href = 'les-tournois';
        }
        await connexion.json()
    }

    async function sendFormSignUp(e) {
        event.preventDefault();
        const form = e.target;


        const inscription = await fetch(form.getAttribute('action'), {
            method: form.getAttribute('method'),
            body: new FormData(form)
        })

        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirm-password").value;
        const erreurContainer = document.getElementById("erreurContainer");

        const paragraph = document.createElement("p");
        const accountValidation = document.createElement("a");

        if (inscription.ok) {
            if ((password != confirmPassword)) {
                paragraph.innerHTML = 'Les mots de passe de correspondents pas !';
                erreurContainer.appendChild(paragraph);
            } else {
                const link = await inscription.json();

                erreurContainer.innerHTML = '';
                accountValidation.href = link;
                accountValidation.innerHTML = 'Validez votre compte';
                erreurContainer.appendChild(accountValidation);
            }
        } else {
            erreurContainer.innerHTML = '';
            paragraph.innerHTML = 'Un compte existe déjà avec cette adresse mail.';
            erreurContainer.appendChild(paragraph);
        }
    }
</script>