<?php 
	Yii::app()->clientScript->registerCoreScript('jquery');
?>

<div id="dialog" title="Podsumowanie">
    <b><a id="pozycje_do_faktury" href="#">Pozycje do faktury (zgrupowane)</a></b><br>
	<table id="pozycje_do_faktury" style="border-collapse: collapse; border: 1px solid black;">
		<tr>
			<td style="border: 1px solid black;">Nr Art.:</td>
			<td style="border: 1px solid black;">Model:</td> 
			<td style="border: 1px solid black;">Typ:</td> 
			<td style="border: 1px solid black;">Średnia grupa cenowa:</td>
			<td style="border: 1px solid black;">Ilość mat:</td>
			<td style="border: 1px solid black;"><b>Cena jednostkowa (Nasza):</b></td>
			<td style="border: 1px solid black;">Cena jednostkowa (Reality):</td>
			<td style="border: 1px solid black;">Nazwa na FV:</td>
			<td style="border: 1px solid black;">Liczba:</td>
			<td style="border: 1px solid black;"><b>Cena całkowita:</b></td>
		</tr>
<?php 
	$suma=0;
	$suma_check=true;
	$liczba=0;
	
	foreach ($Orders1 as $key => $Order) {
		echo "<tr>";
		echo "<td style=\"border: 1px solid black;\">$Order->articleArticle_article_number</td>";
		echo "<td style=\"border: 1px solid black;\">$Order->articleArticle_model_name</td>";
		echo "<td style=\"border: 1px solid black;\">$Order->articleArticle_model_type</td>";
		echo "<td style=\"border: 1px solid black;\">$Order->fabrics_fabric_price_group</td>";
		echo "<td style=\"border: 1px solid black;\">$Order->articleArticle_article_all_textile_amount</td>";
		# wybranym osobą pokazujemy ceny
		if (in_array(Yii::app()->user->name, array('asia', 'gosia', 'mara', 'mariola', 'michalina'))) {
			$our_prices=array(
				1 =>$Order->articleArticle_price_in_pg1,
				2 =>$Order->articleArticle_price_in_pg2,
				3 =>$Order->articleArticle_price_in_pg3,
				4 =>$Order->articleArticle_price_in_pg4,
				5 =>$Order->articleArticle_price_in_pg5,
				6 =>$Order->articleArticle_price_in_pg6,
				7 =>$Order->articleArticle_price_in_pg7,				 	
			);
			$order_price=$Order->order_price;
		} else {
			$our_prices=null;
			$order_price=null;
		}
		$our_price=isset($our_prices[$Order->fabrics_fabric_price_group]) ? $our_prices[$Order->fabrics_fabric_price_group] : null ;
		echo "<td style=\"border: 1px solid black;\"><b>" . $our_price . "</b></td>";
		echo "<td style=\"border: 1px solid black;\">$order_price</td>";
		echo "<td style=\"border: 1px solid black;\">$Order->articleArticle_model_name - $Order->articleArticle_model_type (PG $Order->fabrics_fabric_price_group)</td>";
		echo "<td style=\"border: 1px solid black;\">$Order->article_amount</td>";
		if (isset($our_price)) {
			$our_price_sum=$our_price * $Order->article_amount;
		} else {
			$our_price_sum="<font color=\"red\">uzgodnić z Michaliną</font>";
			$suma_check=false;
		}
		echo "<td style=\"border: 1px solid black;\"><b>" . $our_price_sum . "</b></td>";
		
		// echo "<td style=\"border: 1px solid black;\">$Order->articleArticle_price_in_pg1</td>";
		// echo "<td style=\"border: 1px solid black;\">$Order->articleArticle_price_in_pg2</td>";
		// echo "<td style=\"border: 1px solid black;\">$Order->articleArticle_price_in_pg3</td>";
		// echo "<td style=\"border: 1px solid black;\">$Order->articleArticle_price_in_pg4</td>";
		// echo "<td style=\"border: 1px solid black;\">$Order->articleArticle_price_in_pg5</td>";
		// echo "<td style=\"border: 1px solid black;\">$Order->articleArticle_price_in_pg6</td>";
		// echo "<td style=\"border: 1px solid black;\">$Order->articleArticle_price_in_pg7</td>";
		
		$suma+=$our_price * $Order->article_amount;
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
	echo "<td style=\"border: 1px solid black;\"></td>";
	echo "<td style=\"border: 1px solid black;\"></td>";
	echo "<td style=\"border: 1px solid black;\">$liczba</td>";
	if ($suma_check == false) {
		$suma="<font color=\"red\">brak kilku cen aby policzyć</font>";
	}
	echo "<td style=\"border: 1px solid black;\"><b>$suma</b></td>";
	echo "</tr>";
?>
	</table>
	
<?php 
/* echo "<pre>";
var_dump($Order);
echo "</pre>"; */
?>
	<b><a id="lista_numerow" href="#">Lista numerów zamówień do faktury</a></b><br>
	<table id="lista_numerow" style="border-collapse: collapse; border: 1px solid black;">
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

	<b><a id="pozycje_do_faktury_szczegoly" href="#">Pozycje do faktury (szczegóły)</a></b><br>
	<table id="pozycje_do_faktury_szczegoly" style="border-collapse: collapse; border: 1px solid black;">
		<tr>
			<td style="border: 1px solid black;">Nr Art.:</td>
			<td style="border: 1px solid black;">Model:</td> 
			<td style="border: 1px solid black;">Typ:</td> 
				<td style="border: 1px solid black;">deseń 1 - nr mat.:</td>
				<td style="border: 1px solid black;">deseń 2 - nr mat.:</td>
				<td style="border: 1px solid black;">deseń 1 - grupa cenowa:</td>
				<td style="border: 1px solid black;">deseń 2 - grupa cenowa:</td>
			<td style="border: 1px solid black;">Średnia grupa cenowa:</td>
			<td style="border: 1px solid black;">Ilość mat:</td>
			<td style="border: 1px solid black;"><b>Cena jednostkowa (Nasza):</b></td>
			<td style="border: 1px solid black;">Cena jednostkowa (Reality):</td>
			<td style="border: 1px solid black;">Nazwa na FV:</td>
			<td style="border: 1px solid black;">Liczba:</td>
			<td style="border: 1px solid black;"><b>Cena całkowita:</b></td>
		</tr>
<?php 
	$suma=0;
	$suma_check=true;
	$liczba=0;
	
	foreach ($Orders3 as $key => $Order) {
		echo "<tr>";
		echo "<td style=\"border: 1px solid black;\">$Order->articleArticle_article_number</td>";
		echo "<td style=\"border: 1px solid black;\">$Order->articleArticle_model_name</td>";
		echo "<td style=\"border: 1px solid black;\">$Order->articleArticle_model_type</td>";
		echo "<td style=\"border: 1px solid black;\">$Order->textiles1_textile_number</td>";
		echo "<td style=\"border: 1px solid black;\">$Order->textiles2_textile_number</td>";
			/* echo "<td style=\"border: 1px solid black;\">$Order->textiles1_textile_price_groupe</td>";
			echo "<td style=\"border: 1px solid black;\">$Order->textiles2_textile_price_groupe</td>"; */
		echo "<td style=\"border: 1px solid black;\"> </td>";
		echo "<td style=\"border: 1px solid black;\"> </td>";
		echo "<td style=\"border: 1px solid black;\">$Order->fabrics_fabric_price_group</td>";
		echo "<td style=\"border: 1px solid black;\">$Order->articleArticle_article_all_textile_amount</td>";
		# wybranym osobą pokazujemy ceny
		if (in_array(Yii::app()->user->name, array('asia', 'gosia', 'mara', 'mariola', 'michalina'))) {
			$our_prices=array(
				1 =>$Order->articleArticle_price_in_pg1,
				2 =>$Order->articleArticle_price_in_pg2,
				3 =>$Order->articleArticle_price_in_pg3,
				4 =>$Order->articleArticle_price_in_pg4,
				5 =>$Order->articleArticle_price_in_pg5,
				6 =>$Order->articleArticle_price_in_pg6,
				7 =>$Order->articleArticle_price_in_pg7,				 	
			);
			$order_price=$Order->order_price;
		} else {
			$our_prices=null;
			$order_price=null;
		}
		$our_price=isset($our_prices[$Order->fabrics_fabric_price_group]) ? $our_prices[$Order->fabrics_fabric_price_group] : null ;
		echo "<td style=\"border: 1px solid black;\"><b>" . $our_price . "</b></td>";
		echo "<td style=\"border: 1px solid black;\">$order_price</td>";
		echo "<td style=\"border: 1px solid black;\">$Order->articleArticle_model_name - $Order->articleArticle_model_type (PG $Order->fabrics_fabric_price_group)</td>";
		echo "<td style=\"border: 1px solid black;\">$Order->article_amount</td>";
		if (isset($our_price)) {
			$our_price_sum=$our_price * $Order->article_amount;
		} else {
			$our_price_sum="<font color=\"red\">uzgodnić z Michaliną</font>";
			$suma_check=false;
		}
		echo "<td style=\"border: 1px solid black;\"><b>" . $our_price_sum . "</b></td>";
		
		// echo "<td style=\"border: 1px solid black;\">$Order->articleArticle_price_in_pg1</td>";
		// echo "<td style=\"border: 1px solid black;\">$Order->articleArticle_price_in_pg2</td>";
		// echo "<td style=\"border: 1px solid black;\">$Order->articleArticle_price_in_pg3</td>";
		// echo "<td style=\"border: 1px solid black;\">$Order->articleArticle_price_in_pg4</td>";
		// echo "<td style=\"border: 1px solid black;\">$Order->articleArticle_price_in_pg5</td>";
		// echo "<td style=\"border: 1px solid black;\">$Order->articleArticle_price_in_pg6</td>";
		// echo "<td style=\"border: 1px solid black;\">$Order->articleArticle_price_in_pg7</td>";
		
		$suma+=$our_price * $Order->article_amount;
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
	echo "<td style=\"border: 1px solid black;\"></td>";
	echo "<td style=\"border: 1px solid black;\"></td>";
	echo "<td style=\"border: 1px solid black;\"></td>";
	echo "<td style=\"border: 1px solid black;\"></td>";
	echo "<td style=\"border: 1px solid black;\"></td>";
	echo "<td style=\"border: 1px solid black;\"></td>";
	echo "<td style=\"border: 1px solid black;\">$liczba</td>";
	if ($suma_check == false) {
		$suma="<font color=\"red\">brak kilku cen aby policzyć</font>";
	}
	echo "<td style=\"border: 1px solid black;\"><b>$suma</b></td>";
	echo "</tr>";
?>
	</table>
	
	<b><a id="rozklad_tygodniowy" href="#">Rozkład tygodniowy poszczególnych modeli</a></b><br>
	<table id="rozklad_tygodniowy" style="border-collapse: collapse; border: 1px solid black;">
		<tr>
			<td style="border: 1px solid black;">Model:</td> 
			<td style="border: 1px solid black;">Typ:</td> 
			<td style="border: 1px solid black;">Termin</td>
			<td style="border: 1px solid black;">Liczba:</td>
		</tr>
<?php 
	$suma=0;
	$oldTerm=0;
	foreach ($Orders4 as $key => $Order) {
		if ($oldTerm != 0 && $oldTerm != $Order->order_term) {
			echo "<tr>";
			echo "<td style=\"border: 1px solid black;\"></td>";
			echo "<td style=\"border: 1px solid black;\"></td>";
			echo "<td style=\"border: 1px solid black;\"></td>";
			echo "<td style=\"border: 1px solid black; text-align: center;\"><B>$suma</B></td>";
			echo "</tr>";
			echo "<tr><td>&nbsp</td></tr>";
			$suma=0;
		}
		$oldTerm=$Order->order_term;

		echo "<tr>";
		echo "<td style=\"border: 1px solid black;\">$Order->articleArticle_model_name</td>";
		echo "<td style=\"border: 1px solid black;\">$Order->articleArticle_model_type</td>";
		echo "<td style=\"border: 1px solid black;\">$Order->order_term</td>";
		echo "<td style=\"border: 1px solid black;\">$Order->article_amount</td>";
		$suma+=$Order->article_amount;
		echo "</tr>";
	}
	echo "<tr>";
	echo "<td style=\"border: 1px solid black;\"></td>";
	echo "<td style=\"border: 1px solid black;\"></td>";
	echo "<td style=\"border: 1px solid black;\"></td>";
	echo "<td style=\"border: 1px solid black; text-align: center;\"><B>$suma</B></td>";
	echo "</tr>";
?>
	</table>
	
	<b><a id="rozklad" href="#">Rozkład poszczególnych modeli</a></b><br>
	<table id="rozklad" style="border-collapse: collapse; border: 1px solid black;">
		<tr>
			<td style="border: 1px solid black;">Nr Art.</td>
			<td style="border: 1px solid black;">Model:</td> 
			<td style="border: 1px solid black;">Typ:</td> 
			<td style="border: 1px solid black;">Liczba:</td>
		</tr>
<?php 
	$suma=0;
	$oldModel=null;
	foreach ($Orders5 as $key => $Order) {
		if(preg_match('/Kissensatz/',$Order->articleArticle_model_type)) {
			$currentModel=$Order->articleArticle_model_name . " (kissen)";
		} else if (preg_match('/Hockerbank/',$Order->articleArticle_model_type)) {
			$currentModel=$Order->articleArticle_model_name . " (hocker)";
		} else {
			$currentModel=$Order->articleArticle_model_name;
		}
		if ($oldModel != null && $oldModel != $currentModel) {
			echo "<tr>";
			echo "<td style=\"border: 1px solid black;\"></td>";
			echo "<td style=\"border: 1px solid black;\"></td>";
			echo "<td style=\"border: 1px solid black;\"></td>";
			echo "<td style=\"border: 1px solid black; text-align: center;\"><B>$suma</B></td>";
			echo "</tr>";
			echo "<tr><td>&nbsp</td></tr>";
			$suma=0;
		}
		$oldModel=$currentModel;
		
		echo "<tr>";
		echo "<td style=\"border: 1px solid black;\">$Order->articleArticle_article_number</td>";
		echo "<td style=\"border: 1px solid black;\">$Order->articleArticle_model_name</td>";
		echo "<td style=\"border: 1px solid black;\">$Order->articleArticle_model_type</td>";
		echo "<td style=\"border: 1px solid black;\">$Order->article_amount</td>";
		$suma+=$Order->article_amount;
		echo "</tr>";
	}
	echo "<tr>";
	echo "<td style=\"border: 1px solid black;\"></td>";
	echo "<td style=\"border: 1px solid black;\"></td>";
	echo "<td style=\"border: 1px solid black;\"></td>";
	echo "<td style=\"border: 1px solid black; text-align: center\"><B>$suma</B></td>";
	echo "</tr>";
?>
	</table>
	
	<b><a id="plan_sieroty" href="#">Plan - sieroty</a></b><br>
	<table id="plan_sieroty" style="border-collapse: collapse; border: 1px solid black;">
		<tr>
			<td style="border: 1px solid black;">nr zam.</td>
			<td style="border: 1px solid black;">pozycja</td> 
			<td style="border: 1px solid black;">plan</td> 
		</tr>
<?php 
	foreach ($Orders6 as $key => $Order) {
		echo "<tr>";
			echo "<td style=\"border: 1px solid black;\">$Order->order_number</td>";
			echo "<td style=\"border: 1px solid black;\">$Order->buyer_order_number</td>";
			echo "<td style=\"border: 1px solid black;\">$Order->article_planed</td>";
		echo "</tr>";
	}
?>
	</table>
	
	<b><a id="plan" href="#">Na potrzeby przeniesienia planu do Excella</a></b><br>
	<table id="plan" style="border-collapse: collapse; border: 1px solid black;">
		<tr>
			<td colspan=2 style="border: 1px solid black;"><B>Funkcja:</B> =JEŻELI.BŁĄD(WYSZUKAJ.PIONOWO(A2&"_"&U2;$Tabelle2.$A$1:$B$999;2;FAŁSZ());"")</td>
		</tr>
		<tr>
			<td colspan="2" style="border: 1px solid black;">&nbsp;</td>
		</tr>
		<tr>
			<td style="border: 1px solid black;"><B>Nr. do planu</B></td>
			<td style="border: 1px solid black;"><B>Nr. tyg.</B></td>
		</tr>
<?php 
	foreach ($Orders7 as $key => $Order) {
		echo "<tr>";
			echo "<td style=\"border: 1px solid black;\">$Order->order_number</td>";
			echo "<td style=\"border: 1px solid black;\">$Order->article_planed</td>";
		echo "</tr>";
	}
?>
	</table>
</div>

<script type="text/javascript">
/*<![CDATA[*/
	 $(document).ready(function() {
		$("a#pozycje_do_faktury").click(function(event) {
			$("table#pozycje_do_faktury").toggle();
			event.preventDefault();
		});
		$("a#lista_numerow").click(function(event) {
			$("table#lista_numerow").toggle();
			event.preventDefault();
		});
		$("a#pozycje_do_faktury_szczegoly").click(function(event) {
			$("table#pozycje_do_faktury_szczegoly").toggle();
			event.preventDefault();
		});
		$("a#rozklad_tygodniowy").click(function(event) {
			$("table#rozklad_tygodniowy").toggle();
			event.preventDefault();
		});
		$("a#rozklad").click(function(event) {
			$("table#rozklad").toggle();
			event.preventDefault();
		});
		$("a#plan_sieroty").click(function(event) {
			$("table#plan_sieroty").toggle();
			event.preventDefault();
		});
		$("a#plan").click(function(event) {
			$("table#plan").toggle();
			event.preventDefault();
		});

		
	 });
/*]]>*/
</script>