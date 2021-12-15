<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="style.css" />
    <title>Premiers tests du CSS</title>
</head>
<body>
    <?php
    $bdd = mysqli_connect('172.28.100.3', 'mviougea', 'elini01', 'mviougea_atlantik');
    if (!$bdd) {
        die("error");
    } else {
        //echo "connexion réussie";
    }
    ?>
    <table>
        <tr>
            <th ROWSPAN="2">Categorie</th>
            <th ROWSPAN="2">Type</th>
            <th COLSPAN="3">Periode</th>
        </tr>
        <tr>
            <?php
            $requeteDate = 'SELECT dateDebutPeriode, dateFinPeriode FROM periode';
            $test2 = mysqli_query($bdd, $requeteDate);
            while ($donnees = mysqli_fetch_array($test2)) {
            ?>
                <td><?php echo $donnees['dateDebutPeriode'] . "<br>" . $donnees['dateFinPeriode']; ?></td>
            <?php
            } //fin du pour chaque periode
            ?>
        </tr>
        <?php
        $txtLettreCat = "SELECT lettreCategorie FROM `categorie`";
        $resLettreCat = mysqli_query($bdd, $txtLettreCat);

        while ($donnees = mysqli_fetch_array($resLettreCat)) {
            //j'obtiens le nb de typeCategorie
            $lettre = $donnees['lettreCategorie'];
            $txtReqNbTypeCategorie = "SELECT COUNT(CodeTypeCategorie) FROM `typeCategorie` WHERE lettreCategorie='" . $lettre . "'";
            $resultat = mysqli_query($bdd, $txtReqNbTypeCategorie);
            $tabRes = mysqli_fetch_array($resultat);
            $nbTypeCategorie = $tabRes[0];
        ?>
            <tr>
                <!-- j'affiche la categorie(lettre et libelle) -->
                <td rowspan="<?= $nbTypeCategorie ?>"><?php echo $donnees['lettreCategorie']; ?></td>
                <?php
                //j'obtiens les typeCategorie de la categorie
                $txtReqCodeTypeCategorie = "SELECT CodeTypeCategorie, libelleTypeCategorie FROM `typeCategorie` WHERE lettreCategorie='" . $lettre . "'";
                $resCategorie = mysqli_query($bdd, $txtReqCodeTypeCategorie);
                //pour chaque typeCategorie de la categorie
                while ($tabCateg = mysqli_fetch_array($resCategorie)) {
                ?>
                    <td>
                        <!-- j'affiche le typeCategorie -->
                        <?= $tabCateg["CodeTypeCategorie"] . " - " . $tabCateg["libelleTypeCategorie"] ?>
                    </td>
                    <?php
                    //j'obtiens les tarifs pour le typeCategorie
                    $txtReqTarifs = "SELECT prix FROM Tarif WHERE codeTypeCategorie='" . $tabCateg["CodeTypeCategorie"] . "' AND codeLiaison='15'";
                    $resReqTarifs = mysqli_query($bdd, $txtReqTarifs);
                    //pour chaque tarif du typeCategorie
                    while ($tabTarifs = mysqli_fetch_array($resReqTarifs)) {
                    ?>
                        <td>
                            <!-- j'affiche le tarif -->
                            <?= $tabTarifs["prix"] ?>
                        </td>
                    <?php
                    } //fin du pour chaque tarif
                    ?>
            </tr>
    <?php
                } //fin du pour chaque codeTypeCategorie
            } //fin du pour chaque lettre
    ?>
    </table>
</body>
</html>