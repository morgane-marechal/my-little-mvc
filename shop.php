<?php

require_once 'vendor/autoload.php';

use App\Model\Clothing;
use App\Model\Electronic;

$clothing = new Clothing();
$clothes = $clothing->findAll();
$electronic = new Electronic();
$electronics = $electronic->findAll();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job02</title>
</head>

<body>
    <main>
        <h1>Tous les produits</h1>
        <section>
            <h2>Liste des vêtements</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Prix</th>
                        <th>Taille</th>
                        <th>Color</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clothes as $clothe) : ?>
                        <tr>
                            <td><?= $clothe->getName(); ?></td>
                            <td><?= $clothe->getDescription(); ?></td>
                            <td><?= $clothe->getPrice(); ?> €</td>
                            <td><?= $clothe->getSize(); ?></td>
                            <td><?= $clothe->getColor(); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
        <section>
            <h2>Liste des produits électroniques</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Prix</th>
                        <th>Garantie</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($electronics as $electronic) : ?>
                        <tr>
                            <td><?= $electronic->getName(); ?></td>
                            <td><?= $electronic->getDescription(); ?></td>
                            <td><?= $electronic->getPrice(); ?> €</td>
                            <td><?= $electronic->getWarantyFee(); ?> €</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>

</html>