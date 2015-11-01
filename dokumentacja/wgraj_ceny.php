<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=mara_wd15;encoding=utf8', 'mara_wd15', '{password_for_database}',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    echo $e->getMessage() . "\n";
}

try {
    $pdo->beginTransaction();  
    
    $handle = @fopen("Ceny_SO.csv", "r");
    if ($handle) {
        while (($buffer = fgets($handle, 4096)) !== false) {
            $line=explode("^",$buffer);
            echo "$line[0], $line[1], $line[2], $line[3], $line[4], $line[5], $line[6], $line[7], $line[8],  $line[9],  $line[10]\n";

            # insert czy update
            $stmt = $pdo -> prepare('SELECT `article_number` FROM `article` WHERE `article_number` = :article_number');
            $stmt -> bindValue(':article_number', $line[0], PDO::PARAM_INT);
            $stmt -> execute();
            if($stmt -> fetch(PDO::FETCH_ASSOC)) {
                # update
                $stmt->closeCursor();
                $stmt = $pdo -> prepare('UPDATE `article` 
                                         SET `price_in_pg1` = :pg1, `price_in_pg2` = :pg2, `price_in_pg3` = :pg3, 
                                             `price_in_pg4` = :pg4, `price_in_pg5` = :pg5, `price_in_pg6` = :pg6, 
                                             `price_in_pg7` = :pg7, `article_all_textile_amount` = :article_all_textile_amount
                                         WHERE `article_number` = :article_number');
                $stmt -> bindValue(':pg1', $line[1], PDO::PARAM_STR);
                $stmt -> bindValue(':pg2', $line[2], PDO::PARAM_STR);
                $stmt -> bindValue(':pg3', $line[3], PDO::PARAM_STR);
                $stmt -> bindValue(':pg4', $line[4], PDO::PARAM_STR);
                $stmt -> bindValue(':pg5', $line[5], PDO::PARAM_STR);
                $stmt -> bindValue(':pg6', $line[6], PDO::PARAM_STR);
                $stmt -> bindValue(':pg7', $line[7], PDO::PARAM_STR);
                $stmt -> bindValue(':article_all_textile_amount', trim($line[8]), PDO::PARAM_STR);
                $stmt -> bindValue(':article_number', $line[0], PDO::PARAM_INT);
                $stmt -> execute();
                $stmt->closeCursor();
                
            } else {
                # insert
                $stmt->closeCursor();
                $stmt = $pdo -> prepare('INSERT INTO `mara_wd15`.`article` (
                                            `article_number` ,
                                            `model_name` ,
                                            `model_type` ,
                                            `article_all_textile_amount`,
                                            `price_in_pg1` ,
                                            `price_in_pg2` ,
                                            `price_in_pg3` ,
                                            `price_in_pg4` ,
                                            `price_in_pg5` ,
                                            `price_in_pg6` ,
                                            `price_in_pg7`
                                        )
                                            VALUES (:article_number, :model_name, :model_type, :article_all_textile_amount, :pg1, :pg2, :pg3, :pg4, :pg5, :pg6, :pg7
                                        )');
                    $stmt -> bindValue(':article_number', $line[0], PDO::PARAM_INT);
                    $stmt -> bindValue(':model_name', trim($line[9]), PDO::PARAM_STR);
                    $stmt -> bindValue(':model_type', trim($line[10]), PDO::PARAM_STR);
                    $stmt -> bindValue(':article_all_textile_amount', trim($line[8]), PDO::PARAM_STR);
                    $stmt -> bindValue(':pg1', $line[1], PDO::PARAM_STR);
                    $stmt -> bindValue(':pg2', $line[2], PDO::PARAM_STR);
                    $stmt -> bindValue(':pg3', $line[3], PDO::PARAM_STR);
                    $stmt -> bindValue(':pg4', $line[4], PDO::PARAM_STR);
                    $stmt -> bindValue(':pg5', $line[5], PDO::PARAM_STR);
                    $stmt -> bindValue(':pg6', $line[6], PDO::PARAM_STR);
                    $stmt -> bindValue(':pg7', $line[7], PDO::PARAM_STR);
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
