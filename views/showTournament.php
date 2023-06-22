<section>
    <form action="ws/games/1" method="PUT" onsubmit="sendScore(event)">
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
            /* console.log(allParticipants); */
        } catch (error) {
            // Gérer les erreurs
        }
    }
    getParticipants();

    async function sendScore(e) {
        event.preventDefault();
        const form = e.target
        const formData = new FormData(form);
        const body = Object.fromEntries(formData.entries());
        console.log(body)
        const scores = await fetch(form.getAttribute('action'), {
            method: form.getAttribute('method'),
            body: JSON.stringify(body)
        })
        const data = await scores.json()
        console.log('score envoyés');
        console.log(data);
    }
    async function getMatchParticipants() {
        const participants = `ws/games/<?= $id; ?>`;

        try {
            const response = await fetch(participants);
            const allParticipants = await response.json();
            console.log(allParticipants);
        } catch (error) {
            // Gérer les erreurs
        }
    }
    getMatchParticipants();
</script>