<section>
    <a class="btn" href="tournois">Créer un tournoi !</a>
    <div id="tournamentsList"></div>
</section>
<script>
    const fetchData = async () => {
        const allTournaments = 'ws/tournaments';

        const tournamentListDiv = document.getElementById('tournamentsList');

        try {
            const response = await fetch(allTournaments);
            const tournaments = await response.json();

            tournaments.forEach(tournament => {
                const tournamentDiv = document.createElement('div');
                tournamentDiv.className = "tournament";
                tournamentDiv.innerHTML = `
                    <h3 class="tile"><strong>Titre tu tournoi : </strong><span>${tournament.title}</span></h3>
                    <p class="game"><strong>Jeu : </strong><span>${tournament.game}</span></p>
                    <p class="nbParticipants"><strong>Nombre maximum de participants : </strong><span>${tournament.nbParticipants}</span>
                    </p>
                    <p class="date"><strong>Date de debut du tournoi : </strong><span>${tournament.date_start}</span></p>
                    <p class="date"><strong>Date de fin du tournoi : </strong><span>${tournament.date_end}</span></p>
                    <div class="allBtn">
                        <button class="btn" onClick="joinTournament(${tournament.id})">Rejoindre !</button>
                        <button class="btn sec" onClick="showTournament(${tournament.id})">Voir</button>
                    </div>
                `;
                tournamentListDiv.appendChild(tournamentDiv);
            });
        } catch (error) {
            // Gérer les erreurs
        }
    };
    fetchData();

    async function joinTournament(tournamentId) {
        try {
            const join = await fetch(`ws/tournaments/${tournamentId}/join`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            });

            if (join.ok) {
                // Le tournoi a été rejoint avec succès
                alert('Vous avez bien rejoint le tournoi : ' + tournamentId);
                /* window.location.href = `tournois/${tournamentId}`; */
            } else {
                // Gérez les erreurs éventuelles
                alert('Erreur lors de la tentative de rejoindre le tournoi');
            }
        } catch (error) {
            alert('Erreur lors de la requête', error);
        }
    }

    async function showTournament(tournamentId) {
        try {
            const response = await fetch(`ws/tournaments/${tournamentId}/`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            });

            if (response.ok) {
                window.location.href = `tournois/${tournamentId}`;
            } else {
                // Gérez les erreurs éventuelles
                alert('Vous ne pouvez pas voir le tournoi sélectionné');
            }
        } catch (error) {
            alert('Erreur lors de la requête');
        }
    }
</script>