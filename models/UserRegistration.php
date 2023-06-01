<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include_once 'AbstractModel.php';

class UserRegistration extends AbstractModel
{
    public function __construct()
    {
        parent::__construct('users');
    }

    public function registerUser($pseudo, $email, $password, $confirm_password)
    {
        // Vérifiez que les champs obligatoires sont remplis
        if (empty($pseudo) || empty($email) || empty($password)  || empty($confirm_password)) {
            echo "Tous les champs sont obligatoires";
            return;
        }

        // Vérifiez si l'email est déjà présent dans la base de données
        $result = $this->pdo->query("SELECT id FROM users WHERE email = '" . $email . "';")->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            echo "Cet email est déjà utilisé, veuillez vous connecter";
            return;
        }

        // Vérifiez si le mot de passe et la confirmation du mot de passe correspondent
        if ($password !== $confirm_password) {
            echo "Le mot de passe et la confirmation du mot de passe ne correspondent pas";
            return;
        }

        // Générer un salt aléatoire
        $salt = bin2hex(random_bytes(16));

        // Générer un token aléatoire
        $token = bin2hex(random_bytes(32));

        // Concaténer le salt et le mot de passe, puis hacher avec bcrypt
        $password = password_hash($password . $salt, PASSWORD_DEFAULT);

        // Créez une requête SQL pour insérer les informations de l'utilisateur dans la base de données
        $query  = $this->db->query("INSERT INTO users (pseudo, email, password, salt, token) VALUES ('$pseudo', '$email', '$password', '$salt', '$token');");

        if ($query) {
            echo "Votre compte a été créé avec succès.\n";


            /* require '../vendor/autoload.php';

            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'localhost';
                $mail->Port = 25;
                $mail->SMTPAuth = false; // Si votre serveur SMTP nécessite une authentification, passez cette ligne à true et fournissez le nom d'utilisateur et le mot de passe SMTP appropriés.


                $mail->setFrom('inscription@thebigporject.fr', 'Inscription TheBigProject');
                $mail->addAddress($email, $email);

                //Content
                $mail->isHTML(true); //Set email format to HTML
                $mail->CharSet = 'UTF-8';
                $mail->Subject = 'Inscription' . $pseudo;
                $mail->Body = "Bonjour " . $pseudo . ",\n\n" .
                    "Merci de vous être inscrit sur TheBigProject. Veuillez cliquer sur le lien ci-dessous pour valider votre compte :\n\n" .
                    "<a href='http://localhost/theBigProject/Models/Comfirmation.php?pseudo=' . urlencode($pseudo) . '&token=' . urlencode($token)'>Confirmer votre compte</a>" . "\n\n";

                if ($mail->send()) {
                    echo "Votre compte a été créé avec succès, un email vous a été envoyer afin de valider votre compte !\n";
                }
            } catch (Exception $e) {
                echo "L'email n'a pas peu être envoyé. erreur: {$mail->ErrorInfo}";
            } */
        }
    }

    public function __destruct()
    {
        // Fermez la connexion à la base de données
        $this->db = null;
    }
}

// Utilisation de la classe
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userRegistration = new UserRegistration();
    $userRegistration->registerUser($_POST['pseudo'], $_POST['email'], $_POST['password'], $_POST['confirm-password']);
}
