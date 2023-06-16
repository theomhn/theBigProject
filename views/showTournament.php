<section>

</section>
<script>
    async function getParticipants() {
        const participants = `http://localhost/theBigProject/ws/tournaments/<?= $id; ?>/users`;

        try {
            const response = await fetch(participants);
            const allParticipants = await response.json();
            console.log(allParticipants);
        } catch (error) {
            // Gérer les erreurs
        }
    }
    getParticipants();
</script>