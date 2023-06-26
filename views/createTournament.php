<section>
    <form action="ws/tournaments" method="POST" onsubmit="sendFormTournament(event)">
        <div class="input-box">
            <label for="title"> Titre du tournoi: </label>
            <input type="text" name="title" id="tile">
        </div>
        <div class="input-box">
            <label for="game"> Choisissez le jeu: </label>
            <input type="text" name="game" id="game">
        </div>
        <div class="input-box">
            <label for="nbParticipants"> Choisissez le nombre de Participant (max) :</label>
            <input type="number" name="nbParticipants" id="nbParticipants">
        </div>
        <div class="input-box">
            <label for="dateStart"> Choisissez la date du debut du tournois :</label>
            <input type="datetime-local" name="dateStart" id="dateStart">
        </div>
        <div class="input-box">
            <label for="dateEnd"> Choisissez la date de fin du tournois :</label>
            <input type="datetime-local" name="dateEnd" id="dateEnd">
        </div>
        <div class="input-box">
            <input class="btn" type="submit" id="submit" value="Créer le tournoi">
        </div>
    </form>
</section>

<script>
    // Fonction asynchrone pour envoyer le formulaire de création de tournoi
    async function sendFormTournament(e) {
        event.preventDefault(); // Empêche le comportement par défaut du formulaire
        const form = e.target;
        const formData = new FormData(form); // Crée un nouvel objet FormData à partir du formulaire
        const body = Object.fromEntries(formData.entries()); // Convertit les données du formulaire en un objet

        // Effectue une requête fetch pour envoyer les données du formulaire
        const response = await fetch(form.getAttribute('action'), {
            method: form.getAttribute('method'),
            body: JSON.stringify(body)
        });

        const data = await response.json(); // Attend la réponse de la requête et la convertit en JSON
        if (response.ok) {
            alert('tournoi créé'); // Affiche une alerte pour indiquer que le tournoi a été créé
            window.location.href = "les-tournois";
        }

    }
</script>