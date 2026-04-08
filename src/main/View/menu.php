<?php
$title = 'Composition du menu';
$error = isset($error) ? $error : '';
$success = isset($success) ? $success : '';
$menus = isset($menus) && is_array($menus) ? $menus : array();
$plats = isset($plats) && is_array($plats) ? $plats : array();
$utilisateurs = isset($utilisateurs) && is_array($utilisateurs) ? $utilisateurs : array();
$currentMenu = isset($currentMenu) && is_array($currentMenu) ? $currentMenu : null;
?>

<?php ob_start(); ?>
<h1>📋 Composer un menu</h1>

<?php if ($error !== '') : ?>
    <div class="alert alert-error">
        <strong>Erreur :</strong> <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>
<?php if ($success !== '') : ?>
    <div class="alert alert-success">
        <strong>Succès :</strong> <?php echo htmlspecialchars($success); ?>
    </div>
<?php endif; ?>

<h2>Sélectionner un menu existant</h2>
<?php if (count($menus) === 0) : ?>
    <div class="info-box">
        <p>Aucun menu disponible. Créez-en un ci-dessous !</p>
    </div>
<?php else : ?>
    <form method="post" action="<?php echo htmlspecialchars(urlFor('/menu/selectionner')); ?>">
        <label for="menu_id">📚 Menus disponibles :</label>
        <select id="menu_id" name="menu_id" required>
            <option value="">-- Choisir un menu --</option>
            <?php foreach ($menus as $menuOption) : ?>
                <option value="<?php echo (int)$menuOption['id']; ?>" <?php echo ($currentMenu && (int)$currentMenu['id'] === (int)$menuOption['id']) ? 'selected' : ''; ?>>
                    #<?php echo (int)$menuOption['id']; ?> - <?php echo htmlspecialchars($menuOption['nom']); ?> (<?php echo number_format((float)$menuOption['prixTotal'], 2, ',', ' '); ?> EUR)
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn btn-success">Ouvrir ce menu</button>
    </form>
<?php endif; ?>

<h2>Créer un nouveau menu</h2>
<form method="post" action="<?php echo htmlspecialchars(urlFor('/menu/creer')); ?>">
    <label for="nom">📝 Nom du menu :</label>
    <input id="nom" name="nom" type="text" placeholder="ex: Menu Provence" required />

    <label for="createur_id">👨‍🍳 Créateur :</label>
    <select id="createur_id" name="createur_id" required>
        <option value="">-- Choisir --</option>
        <?php foreach ($utilisateurs as $utilisateur) : ?>
            <option value="<?php echo (int)$utilisateur['id']; ?>">
                <?php echo htmlspecialchars($utilisateur['prenom'] . ' ' . $utilisateur['nom']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit" class="btn btn-success">✅ Créer le menu</button>
</form>

<?php if ($currentMenu) : ?>
    <div class="divider"></div>
    
    <div class="info-box">
        <h2>Menu courant : <?php echo htmlspecialchars($currentMenu['nom']); ?> (ID #<?php echo (int)$currentMenu['id']; ?>)</h2>
        <p><strong>Créateur :</strong> <?php echo htmlspecialchars(isset($currentMenu['createurNom']) ? $currentMenu['createurNom'] : 'N/A'); ?></p>
        <p><strong>Date création :</strong> <?php echo htmlspecialchars(isset($currentMenu['dateCreation']) ? $currentMenu['dateCreation'] : 'N/A'); ?></p>
        <p><strong>Date mise à jour :</strong> <?php echo htmlspecialchars(isset($currentMenu['dateMiseAJour']) ? $currentMenu['dateMiseAJour'] : 'N/A'); ?></p>
        <p><strong style="color: var(--accent-color); font-size: 1.1rem;">💰 Prix total : <?php echo number_format((float)(isset($currentMenu['prixTotal']) ? $currentMenu['prixTotal'] : 0), 2, ',', ' '); ?> EUR</strong></p>
    </div>

    <h3>Ajouter un plat au menu</h3>
    <form method="post" action="<?php echo htmlspecialchars(urlFor('/menu/ajouter')); ?>">
        <label for="plat_id">🍽️ Sélectionner un plat :</label>
        <select id="plat_id" name="plat_id" required>
            <option value="">-- Choisir un plat --</option>
            <?php foreach ($plats as $plat) : ?>
                <option value="<?php echo (int)$plat['id']; ?>">
                    <?php echo htmlspecialchars($plat['nom']); ?> (<?php echo number_format((float)$plat['prix'], 2, ',', ' '); ?> EUR)
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn btn-success">➕ Ajouter au menu</button>
    </form>

    <h3>Plats du menu</h3>
    <?php $platsMenu = isset($currentMenu['plats']) && is_array($currentMenu['plats']) ? $currentMenu['plats'] : array(); ?>
    <?php if (count($platsMenu) === 0) : ?>
        <div class="info-box">
            <p>Aucun plat dans ce menu. Ajoutez-en un ci-dessus !</p>
        </div>
    <?php else : ?>
        <table>
            <thead>
                <tr>
                    <th>Plat</th>
                    <th>Prix</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($platsMenu as $platMenu) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($platMenu['nom']); ?></td>
                        <td><?php echo number_format((float)$platMenu['prix'], 2, ',', ' '); ?> EUR</td>
                        <td>
                            <form method="post" action="<?php echo htmlspecialchars(urlFor('/menu/retirer')); ?>" style="display:inline;">
                                <input type="hidden" name="plat_id" value="<?php echo (int)$platMenu['id']; ?>" />
                                <button type="submit" class="btn btn-small">🗑️ Retirer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <hr class="divider" />
    <p>
        <a href="<?php echo htmlspecialchars(urlFor('/commande')); ?>" class="btn btn-success">
            Passer à la commande →
        </a>
    </p>
<?php endif; ?>

<?php $content = ob_get_clean(); ?>
<?php require 'layout.php'; ?>
