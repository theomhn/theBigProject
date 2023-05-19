<section>
    <form action="" method="post">
        <div class="input-box">
            <label for="games"> Choisissez le jeu: </label>
            <select name="games" id="games">
                <option value="" selected>--Choisissez un jeu--</option>
                <option value="rocket-league">Rocket League</option>
                <option value="valorant">Valorant</option>
                <option value="apex-legends">Apex Legends</option>
                <option value="warzone">warzone</option>
            </select>
        </div>
        <div class="input-box">
            <label for="hourEvent"> Choisissez l'heure du debut du tournois :</label>
            <input type="date" name="hourEvent" id="hourEvent">
        </div>
        <div class="input-box">
            <label for="dateStart"> Choisissez la date du debut du tournois :</label>
            <input type="date" name="dateStart" id="dateStart">
        </div>
        <div class="input-box">
            <label for="dateEnd"> Choisissez la date de fin du tournois :</label>
            <input type="date" name="dateEnd" id="dateEnd">
        </div>
        <div class="input-box">
            <input type="submit" name="submit" id="submit" value="Créer le tournois">
        </div>
    </form>
</section>