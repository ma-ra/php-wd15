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
			<td style="border: 1px solid black;">Dostawca:</td>
			<td style="border: 1px solid black;">Nr. Mat.:</td>
			<td style="border: 1px solid black;">Nazwa Mat.:</td>
			<td style="border: 1px solid black;">Materiały - zaznaczone:</td>
			<td style="border: 1px solid black;">Materiały - na magazynie</td>
			<td style="border: 1px solid black;">Materiał - zamówione</td>
			<td style="border: 1px solid black;">Materiał - jeszcze potrzeba</td>
			<td style="border: 1px solid black;">Materiał - pozostało</td>
		</tr>
		<?php 
			foreach ($textiles_pair as $key => $Order) {
				echo "<tr>";
					echo "<td style=\"border: 1px solid black;\">$Order->supplier_name</td>";
					echo "<td style=\"border: 1px solid black;\">$Order->textile_number</td>";
					echo "<td style=\"border: 1px solid black;\">$Order->textile_name</td>";
					echo "<td style=\"border: 1px solid black;\">$Order->textiles_selected</td>";
					echo "<td style=\"border: 1px solid black;\">$Order->textile1_warehouse</td>";
					echo "<td style=\"border: 1px solid black;\">$Order->textiles_ordered</td>";
					echo "<td style=\"border: 1px solid black;\">$Order->textile_yet_need</td>";
					echo "<td style=\"border: 1px solid black;\">$Order->order1_id</td>";
				echo "</tr>";
			}
		?>
	</table>
</div>