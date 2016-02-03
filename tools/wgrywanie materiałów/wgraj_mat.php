<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=mara_wd15;encoding=utf8', 'mara_wd15', '{password_for_database}',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    //$pdo = new PDO('mysql:host=localhost;dbname=wd15;encoding=utf8', 'root', 'q',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    echo $e->getMessage() . "\n";
}

try {
    $pdo->beginTransaction();  
    
    $handle = @fopen("stoff.csv", "r");
    if ($handle) {
        while (($buffer = fgets($handle, 4096)) !== false) {
            $line=explode("^",$buffer);
            echo "$line[0], $line[1], $line[2], $line[3], $line[4]\n";
            # 0 - fabric_number
            # 1 - fabric_name
            # 2 - fabric_price_group
            # 3 - fabric_price
            # 4 - supplier_supplier_id

            # insert czy update
            $stmt = $pdo -> prepare('SELECT `fabric_number` FROM `fabric_collection` WHERE `fabric_number` = :fabric_number');
            $stmt -> bindValue(':fabric_number', $line[0], PDO::PARAM_INT);
            $stmt -> execute();
            if($stmt -> fetch(PDO::FETCH_ASSOC)) {
                # update
                $stmt->closeCursor();
                $stmt = $pdo -> prepare('UPDATE `fabric_collection` 
                                         SET `fabric_number` = :fabric_number, `fabric_name` = :fabric_name, `fabric_price_group` = :fabric_price_group,
                							 `fabric_price` = :fabric_price,  `supplier_supplier_id` = :supplier_supplier_id
                                         WHERE `fabric_number` = :fabric_number');
                $stmt -> bindValue(':fabric_number', $line[0], PDO::PARAM_STR);
                $stmt -> bindValue(':fabric_name', $line[1], PDO::PARAM_STR);
                $stmt -> bindValue(':fabric_price_group', $line[2], PDO::PARAM_INT);
                $stmt -> bindValue(':fabric_price', $line[3], PDO::PARAM_STR);
                $stmt -> bindValue(':supplier_supplier_id', $line[4], PDO::PARAM_INT);
                $stmt -> execute();
                $stmt->closeCursor();
                
            } else {
                # insert
                $stmt->closeCursor();
                $stmt = $pdo -> prepare('INSERT INTO `fabric_collection` (
                                            `fabric_number` ,
                                            `fabric_name` ,
                                            `fabric_price_group` ,
											`fabric_price`,
                                            `supplier_supplier_id`
                                        )
                                            VALUES (:fabric_number, :fabric_name, :fabric_price_group, :fabric_price, :supplier_supplier_id
                                        )');
	                $stmt -> bindValue(':fabric_number', $line[0], PDO::PARAM_STR);
	                $stmt -> bindValue(':fabric_name', $line[1], PDO::PARAM_STR);
	                $stmt -> bindValue(':fabric_price_group', $line[2], PDO::PARAM_INT);
	                $stmt -> bindValue(':fabric_price', $line[3], PDO::PARAM_STR);
	                $stmt -> bindValue(':supplier_supplier_id', $line[4], PDO::PARAM_INT);
                    $stmt -> execute();
                    $stmt->closeCursor();
                }
            }
        }

        $stmt->closeCursor(); unset($stmt);

        $pdo->commit();
    } catch(PDOException $e){
        $pdo->rollBack();
        echo $e->getMessage() . "\n";
    }


    ?>
