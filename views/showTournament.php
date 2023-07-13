<section>
    <!--Ici, j'aurais aimé mettre en place le bracket comme ci-dessous, mais par manque de temps, je n'ai pas pu le faire.
    Je voulais utiliser la librairie brackets-manager.js et brackets-viewer.js pour mettre en place cette fonctionnalité.
    Voici un aperçu du résultat que j'aurais pu obtenir avec un peu plus de temps !-->

    <p>Ceci n'est qu'une image, voir le code page de la page pour les explications, fichier showTournaments</p>
    <img src="public/img/bracket-exemple.png" width="600px" alt="bracket">

    <form action="ws/games/1" method="PUT" onsubmit="sendScore(event)">
        <!-- La saisie des scores fonctionne uniquement pour le premier match du tournoi -->
        <div class="input-box">
            <label for="title"> Score joueur 1 : </label>
            <input type="number" name="score1" id="score1" min="0">
        </div>
        <div class="input-box">
            <label for="game"> Score joueur 2 : </label>
            <input type="number" name="score2" id="score2" min="0">
        </div>
        <div class="input-box">
            <input type="submit" id="submit" class="btn" value="Envoyer les scores">
        </div>
    </form>
</section>
<script>
    async function getParticipants() {
        const participants = `ws/tournaments/<?= $id; ?>/users`;

        try {
            const response = await fetch(participants);
            const allParticipants = await response.json();
        } catch (error) {
            notyf.error(error);
        }
    }
    getParticipants();

    async function sendScore(e) {
        event.preventDefault();
        const form = e.target
        const formData = new FormData(form);
        const body = Object.fromEntries(formData.entries());

        const scores = await fetch(form.getAttribute('action'), {
            method: form.getAttribute('method'),
            body: JSON.stringify(body)
        })
        const data = await scores.json()
        notyf.error('Les Scores envoyés');
    }

    /* fonction qui récupère les participants que je voulais utiliser pour faire la grille avec les matchs et les différentes étapes */
    async function getMatchParticipants() {
        const participants = `ws/games/<?= $id; ?>`;

        try {
            const response = await fetch(participants);
            const allParticipants = await response.json();
        } catch (error) {
            // Gérer les erreurs
        }
    }
    getMatchParticipants();
</script>