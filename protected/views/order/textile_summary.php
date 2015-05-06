<div id="dialog" title="Podsumowanie">
<!-- <b>Przeliczone dane</b>
	<table style="border-collapse: collapse; border: 1px solid black;">
		<tr>
			<td style="border: 1px solid black;">Termin:</td>
			<td style="border: 1px solid black;">Materiał</td>
			<td style="border: 1px solid black;">Suma</td>
		</tr> -->
		<?php 
// 			$suma=0;
// 			$oldTerm=0;
// 			foreach ($textiles as $key => $term) {
// 				foreach ($term as $key2 => $textil) {
// 					if ($oldTerm != 0 && $oldTerm != $key) {
// 						echo "<tr><td>&nbsp</td></tr>";
// 					}
			
// 					echo "<tr>";
// 					echo "<td style=\"border: 1px solid black;\">$key</td>";
// 					echo "<td style=\"border: 1px solid black;\">$key2</td>";
// 					echo "<td style=\"border: 1px solid black;\">$textil</td>";
// 					$oldTerm=$key;
// 					echo "</tr>";
// 				}
// 			}
// 		?>
<!-- </table> -->
	
	<b>Szczegółowe dane</b>
	<table style="border-collapse: collapse; border: 1px solid black;">
		<tr>
			<td style="border: 1px solid black;">Para:</td>
			<td style="border: 1px solid black;">Firma:</td>
			<td style="border: 1px solid black;">Materiał 1:</td>
			<td style="border: 1px solid black;">Materiał 1 - suma:</td>
			<td style="border: 1px solid black;">Firma:</td>
			<td style="border: 1px solid black;">Materiał 2:</td>
			<td style="border: 1px solid black;">Materiał 2 - suma:</td>
			<td style="border: 1px solid black;">Zamówienia:</td>
			<td style="border: 1px solid black;">Nazwy materiałów:</td>
		</tr>
		<?php 
			foreach ($textiles_pair as $key => $Order) {
				echo "<tr>";
					echo "<td style=\"border: 1px solid black;\">$Order->textil_pair</td>";
					echo "<td style=\"border: 1px solid black;\">$Order->textiles1_textile_price_groupe</td>";
					echo "<td style=\"border: 1px solid black;\">$Order->textiles1_textile_number</td>";
					echo "<td style=\"border: 1px solid black;\">$Order->textiles1_textile_name</td>";
					echo "<td style=\"border: 1px solid black;\">$Order->textiles2_textile_price_groupe</td>";
					echo "<td style=\"border: 1px solid black;\">$Order->textiles2_textile_number</td>";
					echo "<td style=\"border: 1px solid black;\">$Order->textiles2_textile_name</td>";
					echo "<td style=\"border: 1px solid black;\">$Order->order_number</td>";
					echo "<td style=\"border: 1px solid black;\">$Order->order_reference</td>";
				echo "</tr>";
			}
		?>
	</table>
</div>