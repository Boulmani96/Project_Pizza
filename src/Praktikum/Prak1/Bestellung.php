<?php
 	//$myvaria = "Variable";
	echo <<< EOT
		 	<header>
		<h1>Bestellung</h1>
			</header>
			<section>
				<h2>Speisekarte</h2>
					<img src="Pizza.jpg" id="Margherita" alt=" " tabindex="-1"/>
							<p>Margherita</p>
							<p>4.00 €</p>
		
					<img src="Pizza.jpg" id="Salami" alt=" " tabindex="-1"/>
							<p>Salami</p>
							<p>4.50 €</p>
		
					<img src="Pizza.jpg" id="Hawaii" alt=" " tabindex="-1"/>
							<p>Hawaii</p>
							<p>5.50 €</p>
			</section>
			<section>
				<form action="https://echo.fbi.h-da.de/" accept-charset="utf-8" method="POST">
					<h2>Warenkorb</h2>
					<select id="warenkorb" name="warenkorb[]" size="4" tabindex="-1" multiple>
						<option>Salami</option>
						<option>Hawaii</option>
					</select>
					<!--<textarea id="warenkorb" name="warenkorb" rows="10" cols="20" tabindex="-1" accesskey="w" placeholder="Der Warenkorb ist leer..." readonly></textarea>-->
					<p>Gesamt Preis: <span id="gesamtPreis">0 </span>€</p>
					
					<input type="text" id="Adresse" name="Adresse" value="" placeholder="Ihre Adresse" tabindex="1"/>
					<input type="button" name="reset" value="Alle Löschen" tabindex="2" onclick="AllLoesche()"/>
					<input type="button" name="AuswahlLoeschen" value="Auswahl löschen" tabindex="3" onclick="AuswahlLoeschen()"/>
					<input type="submit" name="submit" value="Bestellen" tabindex="4"/>
		
				</form>
			</section>
		EOT;
?>