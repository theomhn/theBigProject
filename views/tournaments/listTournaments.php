<section id="tournamentsList"></section>
<script>
    const fetchData = async () => {
        const allTournaments = 'http://localhost/TheBigProject/ws/tournaments';

        try {
            const response = await fetch(allTournaments);
            const tournaments = await response.json();

            const tournamentListDiv = document.getElementById('tournamentsList');

            tournaments.forEach(tournament => {
                const tournamentDiv = document.createElement('div');
                tournamentDiv.className = "tournament";
                console.log(tournament);
                tournamentDiv.innerHTML = `
                <h3 class="tile"><strong>Titre tu tournoi : </strong><span>${tournament.title}</span></h3>
                <p class="game"><strong>Jeu : </strong><span>${tournament.game}</span></p>
                <p class="nbParticipants"><strong>Nombre maximum de participants : </strong><span>${tournament.nbParticipants}</span>
                </p>
                <p class="date"><strong>Date de debut du tournoi : </strong><span>${tournament.date_start}</span></p>
                <p class="date"><strong>Date de fin du tournoi : </strong><span>${tournament.date_end}</span></p>
                <button class="btn">Rejoindre !</button>`;
                tournamentListDiv.appendChild(tournamentDiv);

            });
        } catch (error) {
            // Gérer les erreurs
            // ...
        }
    };
    fetchData();
</script>