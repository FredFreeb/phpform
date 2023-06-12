<?php
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sexe = $_POST['sexe'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $nom = $_POST['nom'] ?? '';
    $dateNaissance = $_POST['date_naissance'] ?? '';
    $statut = $_POST['statut'] ?? '';
    $email = $_POST['email'] ?? '';

    // Vérifier les doublons d'email
    $file = fopen('user.csv', 'r');
    while (($data = fgetcsv($file)) !== false) {
        if ($data[5] == $email) {
            $message = 'Cette adresse email est déjà enregistrée.';
            break;
        }
    }
    fclose($file);

    if ($message === '') {
        // Enregistrement des informations dans le fichier CSV
        $file = fopen('user.csv', 'a');
        fputcsv($file, [$sexe, $prenom, $nom, $dateNaissance, $statut, $email]);
        fclose($file);

        // Redirection vers la page de résultat
        header('Location: result.php?sexe=' . urlencode($sexe) . '&prenom=' . urlencode($prenom) . '&nom=' . urlencode($nom) . '&date_naissance=' . urlencode($dateNaissance) . '&statut=' . urlencode($statut));
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Formulaire</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="home">
    <div class="wrap">
        <h1>Inscrivez-vous</h1>
        <form action="index.php" method="post" class="modern-form">
            <div class="form-group">
                <label for="sexe" class="form-label">Civilité:</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="sexe" id="sexe_monsieur" value="Monsieur" required>
                    <label class="form-check-label" for="sexe_monsieur">Monsieur</label>
                    <input class="form-check-input" type="radio" name="sexe" id="sexe_madame" value="Madame" required>
                    <label class="form-check-label" for="sexe_madame">Madame</label>
                    <input class="form-check-input" type="radio" name="sexe" id="sexe_autre" value="Autre" required>
                    <label class="form-check-label" for="sexe_autre">Autre</label>
                </div>
                <div class="form-group" id="autre_sexe" style="display: none;">
                    <label for="autre_sexe_liste">Précisez:</label>
                    <select name="autre_sexe_liste" id="autre_sexe_liste" class="form-control">
                        <option value="Non-binaire">Non-binaire</option>
                        <option value="Je préfère ne pas préciser">Je préfère ne pas préciser</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="prenom" class="form-label">Prénom:</label>
                <input type="text" name="prenom" id="prenom" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="nom" class="form-label">Nom:</label>
                <input type="text" name="nom" id="nom" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="date_naissance" class="form-label">Date de naissance:</label>
                <input type="date" name="date_naissance" id="date_naissance" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="statut" class="form-label">Statut:</label>
                <select name="statut" id="statut" class="form-control" required>
                    <option value="etudiant">Étudiant</option>
                    <option value="salarie">Salarié</option>
                    <option value="compte">À mon compte</option>
                    <option value="chomage">Au chômage</option>
                </select>
            </div>
            <div class="form-group">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" id="email" class="form-control" required>
                <!--Si mail déjà renseigné alors afficher message-->
                <p><?= $message; ?></p>
            </div>
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
    <script>
    // Afficher ou masquer la liste déroulante selon la sélection du sexe autre
    const autreSexe = document.getElementById('autre_sexe');
    const sexeAutreRadio = document.getElementById('sexe_autre');

    sexeAutreRadio.addEventListener('change', function() {
        if (sexeAutreRadio.checked) {
            autreSexe.style.display = 'block';
        } else {
            autreSexe.style.display = 'none';
        }
    });

    // Masquer la liste déroulante si le bouton autre est déjà décoché au chargement de la page
    if (!sexeAutreRadio.checked) {
        autreSexe.style.display = 'none';
    }
</script>
</body>
</html>