<section>
    <a class="btn" href="tournois">Créer un tournoi !</a>
    <div id="tournamentsList"></div>
</section>

<script>
    const fetchData = async () => {
        const allTournaments = 'ws/tournaments';

        const tournamentListDiv = document.getElementById('tournamentsList');

        // Identifiants des tournois auxquels l'utilisateur a déjà participé
        const joinedTournamentsIds = [];
        try {
            const response = await fetch(allTournaments);
            const tournaments = await response.json();

            const usersTournamentsResponse = await fetch(`ws/tournaments/users/` + <?= USER['id']; ?>);
            const usersTournamentsData = await usersTournamentsResponse.json();

            usersTournamentsData.forEach(userTournament => {
                if (!joinedTournamentsIds.includes(userTournament.tournament_id)) {
                    joinedTournamentsIds.push(userTournament.tournament_id);
                }
            });

            // Effacer les anciens tournois de la page
            while (tournamentListDiv.firstChild) {
                tournamentListDiv.removeChild(tournamentListDiv.firstChild);
            }

            for (let i = 0; i < tournaments.length; i++) {
                const tournament = tournaments[i];

                const tournamentDiv = document.createElement('div');
                tournamentDiv.className = 'tournament';
                tournamentDiv.innerHTML = `
                    <h3 class="tile"><strong>Titre du tournoi : </strong><span>${tournament.title}</span></h3>
                    <p class="game"><strong>Jeu : </strong><span>${tournament.game}</span></p>
                    <p class="nbParticipants"><strong>Nombre maximum de participants : </strong><span>${tournament.nbParticipants}</span></p>
                    <p class="date"><strong>Date de début du tournoi : </strong><span>${tournament.date_start}</span></p>
                    <p class="date"><strong>Date de fin du tournoi : </strong><span>${tournament.date_end}</span></p>
                    <div class="allBtn">
                        ${joinedTournamentsIds.includes(tournament.id)
                        ? `<button class="btn invalid" onClick="leaveTournament(${tournament.id})">Quitter</button>
                        <button class="btn sec" onClick="showTournament(${tournament.id})">Voir</button>`
                        : `<button class="btn valid" onClick="joinTournament(${tournament.id})">Rejoindre</button>`}
                    </div>`;

                tournamentListDiv.appendChild(tournamentDiv);
            }
        } catch (error) {
            notyf.error('fetchData : ' + error);
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

            // Le tournoi a été rejoint avec succès
            if (join.ok) {
                notyf.success('Vous avez bien rejoint le tournoi : ' + tournamentId);
                fetchData();
            } else {
                // Gérez les erreurs éventuelles
                notyf.error('Erreur lors de la tentative de rejoindre le tournoi');
            }
        } catch (error) {
            notyf.error('Erreur lors de la requête ' + error);
        }
    }

    async function leaveTournament(tournamentId) {
        try {
            const leave = await fetch(`ws/tournaments/${tournamentId}/leave`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            });

            // Le tournoi a été quitté avec succès
            if (leave.ok) {
                notyf.success('Vous avez quitté le tournoi : ' + tournamentId);
                fetchData();
            } else {
                // Gérez les erreurs éventuelles
                notyf.error('Erreur lors de la tentative de quitter le tournoi');
            }
        } catch (error) {
            notyf.error('Erreur lors de la requête', error);
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
                notyf.error('Vous ne pouvez pas voir le tournoi sélectionné');
            }
        } catch (error) {
            notyf.error('Erreur lors de la requête');
        }
    }
</script>