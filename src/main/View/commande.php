<?php $title = 'Commande'; ?>

<?php ob_start(); ?>
<h1>Commander le menu</h1>

<?php if ($error !== '') : ?>
	<p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<?php if (count($menuItems) === 0) : ?>
	<p>Votre menu est vide. <a href="<?php echo htmlspecialchars(urlFor('/plats')); ?>">Ajouter des plats</a>.</p>
<?php else : ?>
	<p>
		Total du menu:
		<strong>
			<span id="menuTotal" data-value="<?php echo number_format($menuTotal, 2, '.', ''); ?>">
				<?php echo number_format($menuTotal, 2, ',', ' '); ?>
			</span>
			EUR
		</strong>
	</p>

	<form method="post" action="<?php echo htmlspecialchars(urlFor('/commande/valider')); ?>">
		<label for="quantite">Quantite:</label>
		<input id="quantite" name="quantite" type="number" min="1" value="1" required />
		<br /><br />

		<label for="adresse">Adresse de livraison:</label><br />
		<textarea id="adresse" name="adresse" rows="3" cols="40" required></textarea>
		<br /><br />

		<label for="date_livraison">Date de livraison:</label>
		<input id="date_livraison" name="date_livraison" type="date" required />
		<br /><br />

		<p>Total commande: <strong><span id="orderTotal"><?php echo number_format($menuTotal, 2, ',', ' '); ?></span> EUR</strong></p>

		<button type="submit">Valider la commande</button>
	</form>

	<script>
	function updateOrderTotal() {
		var menuTotal = parseFloat(document.getElementById('menuTotal').getAttribute('data-value'));
		var qty = parseInt(document.getElementById('quantite').value, 10) || 1;
		var total = menuTotal * qty;
		document.getElementById('orderTotal').textContent = total.toFixed(2).replace('.', ',');
	}

	document.getElementById('quantite').addEventListener('input', updateOrderTotal);
	updateOrderTotal();
	</script>
<?php endif; ?>

<?php $content = ob_get_clean(); ?>
<?php require 'layout.php'; ?>


