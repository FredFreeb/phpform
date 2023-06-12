<?php
// variables nécessaires
$sexe = $_GET['sexe'] ?? '';
$statut = $_GET['statut'] ?? '';
$dateNaissance = $_GET['date_naissance'] ?? '';
$nom = $_GET['nom'] ?? '';
$prenom = $_GET['prenom'] ?? '';

$salutation = '';
$message = '';
// initialisation de l'heure
date_default_timezone_set('Europe/Paris');
$heure = date('H');
// variable pour prendre une classe suivant l'heure
$containerClass = '';
//condition suivant l'heure qui influe sur le texte de salutations et l'arrière plan
if ($heure >= 8 && $heure < 12) {
    $salutation = 'Bonjour';
    $containerClass = 'morning';
} elseif ($heure >= 12 && $heure < 19) {
    $salutation = 'Bon après-midi';
    $containerClass = 'afternoon';
} elseif ($heure >= 19 && $heure < 21) {
    $salutation = 'Bonsoir';
    $containerClass = 'sunset';
} else {
    $salutation = 'Bonne nuit';
    $containerClass = 'night';
}
// condition de remplissage du formulaire
if ($sexe !== '' && $prenom !== '' && $nom !== '' && $dateNaissance !== '' && $statut !== '') {
    // Vérifier si la date de naissance est valide en créant des objets pour les manipuler
    $dateNaissanceObj = DateTime::createFromFormat('Y-m-d', $dateNaissance);
    $dateActuelleObj = new DateTime();
// Si la date de naissance existe et non null et si la date de naissance est bien inférieure à aujourd'hui
    if ($dateNaissanceObj && $dateNaissanceObj <= $dateActuelleObj) {
        $anniversaireCourant = new DateTime($dateActuelleObj->format('Y') . '-' . $dateNaissanceObj->format('m-d'));
// Si l'année est avant aujourd'hui alors je rajoute 1 an pour pouvoir calculer le nombre de jours restants
        if ($anniversaireCourant < $dateActuelleObj) {
            $anniversaireCourant->modify('+1 year');
        }
// combien d'année écoulées entre naissance à aujourd'hui diff calcule la différence d'où la condition de si la date est bien inférieure à aujourd'hui
        $age = $dateNaissanceObj->diff($dateActuelleObj)->y;
// si aujourd'hui correspond au jour et mois de ton anniversaire
        if ($dateNaissanceObj->format('m-d') === $dateActuelleObj->format('m-d')) {
            $message = "$salutation $sexe $nom $prenom.<br>Vous êtes né le " . $dateNaissanceObj->format('d/m/Y') ."<br> Aujourd'hui, c'est votre anniversaire<br>" . "Vous avez donc $age ans !<br> Joyeux anniversaire !<br> À dans 365 jours... ";
        } else {
            $prochainsJours = $anniversaireCourant->diff($dateActuelleObj)->days;
            $prochainsJours += 1;
            $message = "$salutation $sexe $nom $prenom.<br> Vous êtes né le " . $dateNaissanceObj->format('d/m/Y') . ",<br> vous avez donc $age ans,<br> et il vous reste " . ($prochainsJours <= 1 ? '1 jour' : $prochainsJours . ' jours') . " avant votre anniversaire.";
        }
    } else {
        $message = 'Veuillez saisir une date de naissance valide.';
    }
} else {
    $message = 'Veuillez remplir le formulaire.';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Résultat</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<!--class pour l'arrière plan-->
<body class="<?= $containerClass; ?>">

    <div class="result wrap">
<!--Affichage du message-->
        <p><?= $message; ?></p>
    </div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
