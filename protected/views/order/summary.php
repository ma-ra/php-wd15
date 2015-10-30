<div id="dialog" title="Podsumowanie">
    <b>Pozycje do faktury</b>
	<table style="border-collapse: collapse; border: 1px solid black;">
		<tr>
			<td style="border: 1px solid black;">Model:</td> 
			<td style="border: 1px solid black;">Typ:</td> 
			<td style="border: 1px solid black;">Średnia grupa cenowa:</td>
			<td style="border: 1px solid black;">Ilość mat:</td>
			<td style="border: 1px solid black;">Cena jednostkowa (Nasza):</td>
			<td style="border: 1px solid black;">Cena jednostkowa (Reality):</td>
			<td style="border: 1px solid black;">Liczba:</td>
			<td style="border: 1px solid black;">Cena całkowita:</td>
		</tr>
<?php 
	$suma=0;
	$liczba=0;
	
	foreach ($Orders1 as $key => $Order) {
		echo "<tr>";
		echo "<td style=\"border: 1px solid black;\">$Order->articleArticle_model_name</td>";
		echo "<td style=\"border: 1px solid black;\">$Order->articleArticle_model_type</td>";
		echo "<td style=\"border: 1px solid black;\">$Order->fabrics_fabric_price_group</td>";
		echo "<td style=\"border: 1px solid black;\">$Order->articleArticle_article_all_textile_amount</td>";
		echo "<td style=\"border: 1px solid black;\"></td>";
		echo "<td style=\"border: 1px solid black;\">$Order->order_price</td>";
		echo "<td style=\"border: 1px solid black;\">$Order->article_amount</td>";
		echo "<td style=\"border: 1px solid black;\">$Order->order_total_price</td>";
		$suma+=$Order->order_total_price;
		$liczba+=$Order->article_amount;
		echo "</tr>";
	}
	echo "<tr><td></td></tr>";
	echo "<tr>";
	echo "<td style=\"border: 1px solid black;\"></td>";
	echo "<td style=\"border: 1px solid black;\"></td>";
	echo "<td style=\"border: 1px solid black;\"></td>";
	echo "<td style=\"border: 1px solid black;\"></td>";
	echo "<td style=\"border: 1px solid black;\"></td>";
	echo "<td style=\"border: 1px solid black;\"></td>";
	echo "<td style=\"border: 1px solid black;\">$liczba</td>";
	echo "<td style=\"border: 1px solid black;\">$suma</td>";
	echo "</tr>";
?>
	</table>
	
	<b>Lista numerów zamówień do faktury</b>
	<table style="border-collapse: collapse; border: 1px solid black;">
		<tr>
			<td>
<?php 
	foreach ($Orders2 as $key => $Order) {
		echo $Order->order_number . ", \n";
	}
?> 
			</td>
		</tr>
	</table>
	
	<b>Rozkład tygodniowy poszczególnych modeli</b>
	<table style="border-collapse: collapse; border: 1px solid black;">
		<tr>
			<td style="border: 1px solid black;">Model:</td> 
			<td style="border: 1px solid black;">Typ:</td> 
			<td style="border: 1px solid black;">Termin</td>
			<td style="border: 1px solid black;">Liczba:</td>
		</tr>
<?php 
	$suma=0;
	$oldTerm=0;
	foreach ($Orders3 as $key => $Order) {
		if ($oldTerm != 0 && $oldTerm != $Order->order_term) {
			echo "<tr><td>&nbsp</td></tr>";
		}

		echo "<tr>";
		echo "<td style=\"border: 1px solid black;\">$Order->articleArticle_model_name</td>";
		echo "<td style=\"border: 1px solid black;\">$Order->articleArticle_model_type</td>";
		echo "<td style=\"border: 1px solid black;\">$Order->order_term</td>";
		$oldTerm=$Order->order_term;
		echo "<td style=\"border: 1px solid black;\">$Order->article_amount</td>";
		$suma+=$Order->article_amount;
		echo "</tr>";
	}
	echo "<tr><td></td></tr>";
	echo "<tr>";
	echo "<td style=\"border: 1px solid black;\"></td>";
	echo "<td style=\"border: 1px solid black;\"></td>";
	echo "<td style=\"border: 1px solid black;\"></td>";
	echo "<td style=\"border: 1px solid black;\">$suma</td>";
	echo "</tr>";
?>
	</table>
</div>