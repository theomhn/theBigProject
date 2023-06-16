<section>
    <form action="ws/score" method="POST" onsubmit="sendScore(event)">
        <div class="input-box">
            <label for="title"> Score joueur 1 : </label>
            <input type="number" name="score1" id="score1">
        </div>
        <div class="input-box">
            <label for="game"> Score joueur 2 : </label>
            <input type="number" name="score2" id="score2">
        </div>
        <div class="input-box">
            <input type="submit" id="submit" value="Envoyer les scores">
        </div>
    </form>
</section>

<script>
    async function sendScore(e) {
        event.preventDefault();
        const form = e.target
        console.log(form);
        const scores = await fetch(form.getAttribute('action'), {
            method: form.getAttribute('method'),
            body: new FormData(form)
        })
        const data = await scores.json()
        console.log('score envoyés');
        alert('score envoyés');
    }
</script>