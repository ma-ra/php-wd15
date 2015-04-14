<div id="dialog" title="Podsumowanie">
	
	<b>Rozkład tygodniowy poszczególnych modeli</b>
	<table style="border-collapse: collapse; border: 1px solid black;">
		<tr>
			<td style="border: 1px solid black;">Termin:</td>
			<td style="border: 1px solid black;">Para:</td>
			<td style="border: 1px solid black;">Materiał 1:</td>
			<td style="border: 1px solid black;">Materiał 1 - suma:</td>
			<td style="border: 1px solid black;">Materiał 2:</td>
			<td style="border: 1px solid black;">Materiał 2 - suma:</td>
		</tr>
		<?php 
			$suma=0;
			$oldTerm=0;
			foreach ($Orders3 as $key => $Order) {
				if ($oldTerm != 0 && $oldTerm != $Order->order_term) {
					echo "<tr><td>&nbsp</td></tr>";
				}
		
				echo "<tr>";
				echo "<td style=\"border: 1px solid black;\">$Order->order_term</td>";
				echo "<td style=\"border: 1px solid black;\">$Order->textil_pair</td>";
				echo "<td style=\"border: 1px solid black;\">$Order->textiles1_textile_number</td>";
				echo "<td style=\"border: 1px solid black;\">$Order->textiles1_textile_name</td>";
				echo "<td style=\"border: 1px solid black;\">$Order->textiles2_textile_number</td>";
				echo "<td style=\"border: 1px solid black;\">$Order->textiles2_textile_name</td>";
				$oldTerm=$Order->order_term;
				echo "</tr>";
			}
		?>
	</table>
</div>