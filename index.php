<?php

include_once ("bling/Bling.php");
include_once("util/DB.php");
include_once("util/Zipcode.php");

$json = file_get_contents('php://input');
$obj  = json_decode($json);

print_r($obj);


$postalCode = str_replace(array(".", "-"), "", $obj->postalCode);

if (strlen($postalCode) == 8) {
    $bling = new Bling();
    $con = new DB();

    $weight = 0;
    foreach ($obj->items as $item) {
        $item_id = $item->id;
        $quantity = intval($item->quantity);
        if ($quantity > 0) {
            $product = $bling->executeGetProduct($item_id);
            if($product->pesoBruto) $weight = $weight + ($quantity * $product->pesoBruto);


            //$product->pesoBruto;
            //$product->larguraProduto;
            //$product->alturaProduto;
            //$product->profundidadeProduto;
            //print_r($product);
        }
    }

    //UF \ FAIXA DE
    echo "peso=".$weight;

    $zipcode = new Zipcode();
    $adddress = $zipcode->getAddress($postalCode);

    print_r($adddress);

    $query = "";
    if ($weight > 0 & $query != "") {
        if ($result = $con->query($query)) {
            while ($row = $result->fetch_row()) {
                printf("%s (%s,%s)\n", $row[0], $row[1], $row[2]);
            }

            $result->close();
        }
    }
}
?>