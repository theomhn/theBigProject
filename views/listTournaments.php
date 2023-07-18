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

                // convertir les dates du tournoi en objets Date
                const endDate = new Date(tournament.date_end);

                // obtenir la date actuelle
                const currentDate = new Date();

                // si le tournoi est terminé et que l'utilisateur n'a pas participé, passer ce tournoi
                if (currentDate >= endDate && !joinedTournamentsIds.includes(tournament.id)) {
                    continue;
                }

                const tournamentDiv = document.createElement('div');
                tournamentDiv.className = 'tournament';
                tournamentDiv.innerHTML = `
                    <h3 class="tile"><strong>Titre du tournoi : </strong><span>${tournament.title}</span></h3>
                    <p class="game"><strong>Jeu : </strong><span>${tournament.game}</span></p>
                    <p class="nbParticipants"><strong>Nombre maximum de participants : </strong><span>${tournament.nbParticipants}</span></p>
                    <p class="date"><strong>Date de début du tournoi : </strong><span>${tournament.date_start}</span></p>
                    <p class="date"><strong>Date de fin du tournoi : </strong><span>${tournament.date_end}</span></p>
                    <div class="allBtn">
                        ${ currentDate > endDate
                            ? (joinedTournamentsIds.includes(tournament.id)
                            ? `<button class="btn sec" onClick="showTournament(${tournament.id})">Voir</button>` : ``)
                            : (joinedTournamentsIds.includes(tournament.id)
                                ? `<button class="btn invalid" onClick="leaveTournament(${tournament.id})">Quitter</button>
                                <button class="btn sec" onClick="showTournament(${tournament.id})">Voir</button>`
                                : `<button class="btn valid" onClick="joinTournament(${tournament.id})">Rejoindre</button>`)
                        }
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
            // récupérer les détails du tournoi
            const tournamentResponse = await fetch(`ws/tournaments/${tournamentId}`);
            const tournamentData = await tournamentResponse.json();

            // obtenir la date actuelle
            const currentDate = new Date();

            // convertir les dates du tournoi en objets Date
            const startDate = new Date(tournamentData.date_start);
            const endDate = new Date(tournamentData.date_end);

            // calculer la différence en jours entre la date actuelle et la date de début
            const diffTime = Math.abs(startDate - currentDate);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            // calculer la date de participation
            const joinDate = new Date(startDate);
            joinDate.setDate(joinDate.getDate() - 3); // remplacer 3 par le nombre de jours avant le début du tournoi où l'utilisateur est autorisé à rejoindre

            // formater la date de participation
            const joinDateFormatted = joinDate.toLocaleDateString('fr-FR', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });

            // vérifier si le tournoi a commencé ou est terminé
            if (currentDate < startDate && diffDays > 3) { // remplacer 3 par le nombre de jours avant le début du tournoi où l'utilisateur est autorisé à rejoindre
                notyf.error(`Vous pourrez rejoindre le tournoi seulement 3 jours avant le début, à partir du ${joinDateFormatted}`);
            }

            if (currentDate > endDate) {
                notyf.error('Le tournoi est déjà terminé');
            }

            // si le tournoi est en cours ou commence dans 3 jours, procéder à la participation
            const join = await fetch(`ws/tournaments/${tournamentId}/join`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            });

            // Le tournoi a été rejoint avec succès
            if (join.ok) {
                notyf.success('Vous avez bien rejoint le tournoi : ' + tournamentData.title);
                fetchData();
            } else {
                // Gérer les erreurs possibles
                /* notyf.error('Erreur lors de la tentative de rejoindre le tournoi'); */
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