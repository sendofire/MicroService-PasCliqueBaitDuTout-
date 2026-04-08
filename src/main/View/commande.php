<?php
$title = 'Commande';
$error = $error ?? '';
$menu = (isset($menu) && is_array($menu)) ? $menu : null;
$utilisateurs = (isset($utilisateurs) && is_array($utilisateurs)) ? $utilisateurs : array();
?>

<?php ob_start(); ?>
<h1>🛒 Commander un menu</h1>

<?php if ($error !== '') : ?>
    <div class="alert alert-error">
        <strong>Erreur :</strong> <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<?php if (!$menu) : ?>
    <div class="info-box">
        <p>❌ Aucun menu sélectionné.</p>
        <p><a href="<?php echo htmlspecialchars(urlFor('/menu')); ?>">← Choisir un menu</a></p>
    </div>
<?php else : ?>
    <?php $prixMenu = (float)(isset($menu['prixTotal']) ? $menu['prixTotal'] : 0); ?>
    
    <div class="info-box">
        <p><strong>Menu sélectionné :</strong> <?php echo htmlspecialchars($menu['nom']); ?> (ID #<?php echo (int)$menu['id']; ?>)</p>
        <p><strong>Prix unitaire :</strong> <span id="menuTotal" data-value="<?php echo number_format($prixMenu, 2, '.', ''); ?>" style="color: var(--accent-color); font-size: 1.1rem;">💰 <?php echo number_format($prixMenu, 2, ',', ' '); ?> EUR</span></p>
    </div>

    <form method="post" action="<?php echo htmlspecialchars(urlFor('/commande/valider')); ?>">
        <label for="abonne_id">👤 Abonné :</label>
        <select id="abonne_id" name="abonne_id" required>
            <option value="">-- Choisir un abonné --</option>
            <?php foreach ($utilisateurs as $utilisateur) : ?>
                <option value="<?php echo (int)$utilisateur['id']; ?>" data-adresse="<?php echo htmlspecialchars($utilisateur['adresse']); ?>">
                    <?php echo htmlspecialchars($utilisateur['prenom'] . ' ' . $utilisateur['nom']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="quantite">📦 Quantité :</label>
        <input id="quantite" name="quantite" type="number" min="1" value="1" required />

        <label for="adresse">📮 Adresse de livraison :</label>
        <textarea id="adresse" name="adresse" rows="3" placeholder="Entrez l'adresse de livraison" required></textarea>

        <label for="date_livraison">📅 Date de livraison :</label>
        <input id="date_livraison" name="date_livraison" type="date" required />

        <div class="info-box">
            <p><strong>💰 Total commande estimé :</strong> <span id="orderTotal" style="font-size: 1.3rem; color: var(--accent-color);"><?php echo number_format($prixMenu, 2, ',', ' '); ?> EUR</span></p>
        </div>

        <button type="submit" class="btn btn-success">✅ Valider la commande</button>
    </form>

    <script>
    function updateOrderTotal() {
        var menuTotal = parseFloat(document.getElementById('menuTotal').getAttribute('data-value'));
        var qty = parseInt(document.getElementById('quantite').value, 10) || 1;
        document.getElementById('orderTotal').textContent = (menuTotal * qty).toFixed(2).replace('.', ',') + ' EUR';
    }

    function fillAddressFromUser() {
        var select = document.getElementById('abonne_id');
        var selected = select.options[select.selectedIndex];
        if (!selected) {
            return;
        }
        var addr = selected.getAttribute('data-adresse');
        if (addr) {
            document.getElementById('adresse').value = addr;
        }
    }

    document.getElementById('quantite').addEventListener('input', updateOrderTotal);
    document.getElementById('abonne_id').addEventListener('change', fillAddressFromUser);
    updateOrderTotal();
    </script>
<?php endif; ?>

<?php $content = ob_get_clean(); ?>
<?php require 'layout.php'; ?>
