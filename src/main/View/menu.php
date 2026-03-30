<?php $title = 'Composition du menu'; ?>

<?php ob_start(); ?>
<h1>Composer un menu</h1>

<form method="post" action="<?php echo htmlspecialchars(urlFor('/menu/sauver')); ?>" style="margin-bottom:12px;">
    <label for="creator">Nom du createur:</label>
    <input id="creator" name="creator" type="text" value="<?php echo htmlspecialchars($menu['creator']); ?>" />
    <button type="submit">Enregistrer</button>
</form>

<p>Date creation: <?php echo htmlspecialchars($menu['created_at']); ?></p>
<p>Date modification: <?php echo htmlspecialchars($menu['updated_at']); ?></p>

<h2>Plats selectionnes</h2>

<?php if (count($items) === 0) : ?>
    <p>Aucun plat dans le menu.</p>
<?php else : ?>
    <table border="1" cellpadding="6" cellspacing="0">
        <tr>
            <th>Plat</th>
            <th>Prix unitaire</th>
            <th>Quantite</th>
            <th>Sous-total</th>
            <th>Action</th>
        </tr>
        <?php foreach ($items as $row) : ?>
            <tr>
                <td><?php echo htmlspecialchars($row['nom']); ?></td>
                <td class="unit-price" data-value="<?php echo number_format($row['prix'], 2, '.', ''); ?>">
                    <?php echo number_format($row['prix'], 2, ',', ' '); ?> EUR
                </td>
                <td>
                    <input
                        class="qty-input"
                        type="number"
                        min="1"
                        value="<?php echo (int)$row['quantite']; ?>"
                        style="width:60px;"
                        readonly
                    />
                </td>
                <td class="line-total"><?php echo number_format($row['sous_total'], 2, ',', ' '); ?> EUR</td>
                <td>
                    <form method="post" action="<?php echo htmlspecialchars(urlFor('/menu/retirer')); ?>">
                        <input type="hidden" name="plat_id" value="<?php echo (int)$row['id']; ?>" />
                        <button type="submit">Retirer 1</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<h3>Total menu: <span id="menuTotal"><?php echo number_format($total, 2, ',', ' '); ?></span> EUR</h3>

<p><a href="<?php echo htmlspecialchars(urlFor('/plats')); ?>">Ajouter d'autres plats</a></p>
<p><a href="<?php echo htmlspecialchars(urlFor('/commande')); ?>">Passer a la commande</a></p>

<script>
function updateMenuTotal() {
    var total = 0;
    var rows = document.querySelectorAll('table tr');
    for (var i = 1; i < rows.length; i++) {
        var priceEl = rows[i].querySelector('.unit-price');
        var qtyEl = rows[i].querySelector('.qty-input');
        var lineEl = rows[i].querySelector('.line-total');
        if (!priceEl || !qtyEl || !lineEl) {
            continue;
        }
        var price = parseFloat(priceEl.getAttribute('data-value'));
        var qty = parseInt(qtyEl.value, 10);
        var lineTotal = price * qty;
        lineEl.textContent = lineTotal.toFixed(2).replace('.', ',') + ' EUR';
        total += lineTotal;
    }
    var totalEl = document.getElementById('menuTotal');
    if (totalEl) {
        totalEl.textContent = total.toFixed(2).replace('.', ',');
    }
}

updateMenuTotal();
</script>

<?php $content = ob_get_clean(); ?>
<?php require 'layout.php'; ?>

