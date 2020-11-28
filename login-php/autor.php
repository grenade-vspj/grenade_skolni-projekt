<div>

	<input type="text" name="udaje" placeholder="Kontaktni udaje">
	<br><br>

	<form action="upload.php" method="POST" enctype="multipart/form-data">
		<input type="text" name="nazev" placeholder="Nazev clanku" required>
		<br><br>
		<input type="file" name="file" placeholder="Cesta k clanku" required>
		<button type="submit" name="submit">Nahrat</button>
	</form>


</div>