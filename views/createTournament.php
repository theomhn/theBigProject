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
    async function sendFormTournament(e) {
        event.preventDefault();
        const form = e.target
        console.log(form);
        const response = await fetch(form.getAttribute('action'), {
            method: form.getAttribute('method'),
            body: new FormData(form)
        })
        const data = await response.json()
        alert('tournoi créé');
    }
</script>