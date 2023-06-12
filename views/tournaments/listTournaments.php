<section>
    <a href="tournois">Créer un tournoi !</a>
    <div id="tournamentsList"></div>
</section>
<script>
    const fetchData = async () => {
        const allTournaments = 'http://localhost/theBigProject/ws/tournaments';

        try {
            const response = await fetch(allTournaments);
            const tournaments = await response.json();

            const tournamentListDiv = document.getElementById('tournamentsList');

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
                /* console.log(tournament); */
            });
        } catch (error) {
            // Gérer les erreurs
            // ...
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
                body: JSON.stringify({}) // Si j'ai besoin d'envoyer des données supplémentaires, c'est ici
            });

            if (join.ok) {
                // Le tournoi a été rejoint avec succès
                console.log('Vous avez bien rejoint le tournoi : ' + tournamentId);
                /* alert('Vous avez bien rejoint le tournoi : ' + tournamentId); */
                // @TODO faire les actions nécessaires après avoir rejoint le tournoi, comme actualiser l'affichage, etc.
            } else {
                // Gérez les erreurs éventuelles
                console.log('Erreur lors de la tentative de rejoindre le tournoi');
            }
        } catch (error) {
            console.log('Erreur lors de la requête', error);
        }
    }

    async function showTournament(tournamentId) {
        try {
            const response = await fetch(`ws/tournaments/${tournamentId}/`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({}) // Si j'ai besoin d'envoyer des données supplémentaires, c'est ici
            });

            if (response.ok) {

            } else {
                // Gérez les erreurs éventuelles
                console.log('Erreur lors de la tentative de rejoindre le tournoi');
            }
        } catch (error) {
            console.log('Erreur lors de la requête', error);
        }
    }
</script>