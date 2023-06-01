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
                tournamentDiv.className = 'tournament';

                const title = document.createElement('h3');
                title.className = 'title';
                title.innerHTML = "<strong>Titre tu tournoi : </strong>" + tournament.title;

                const game = document.createElement('p');
                game.className = 'description';
                game.innerHTML = "<strong>Jeu : </strong>" + tournament.game;

                const nbParticipants = document.createElement('p');
                nbParticipants.className = 'nbParticipants';
                nbParticipants.innerHTML = "<strong>Nombre maximum de participants : </strong>" + tournament.nbParticipants;

                const dateStart = document.createElement('p');
                dateStart.className = 'date';
                dateStart.innerHTML = "<strong>Date de debut du tournoi : </strong>" + tournament.date_start;

                const dateEnd = document.createElement('p');
                dateEnd.className = 'date';
                dateEnd.innerHTML = "<strong>Date de fin du tournoi : </strong>" + tournament.date_end;

                // Ajouter les éléments au conteneur principal
                tournamentDiv.appendChild(title);
                tournamentDiv.appendChild(game);
                tournamentDiv.appendChild(nbParticipants);
                tournamentDiv.appendChild(dateStart);
                tournamentDiv.appendChild(dateEnd);

                tournamentListDiv.appendChild(tournamentDiv);
                console.log(tournament);
            });
        } catch (error) {
            // Gérer les erreurs
            // ...
        }
    };

    fetchData();
</script>