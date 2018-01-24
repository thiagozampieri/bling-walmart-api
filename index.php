<?php

include_once("bling/Bling.php");
include_once("util/DB.php");
include_once("util/Zipcode.php");

$json = file_get_contents('php://input');
$obj  = json_decode($json);

$obj->shipmentInfos = array();

//print_r($obj);
$postalCode = str_replace(array(".", "-"), "", $obj->postalCode);
if (strlen($postalCode) == 8) {
    $bling = new Bling();
    $zipcode = new Zipcode();

    foreach ($obj->items as $key => $item) {
        $item_id = $item->id;
        $quantity = intval($item->quantity);
        $weight = 0;
        unset($item->seller);
        if ($quantity > 0) {
            $product = $bling->executeGetProduct($item_id);
            //print_r($product);
            if ($product) {

                if ($product->pesoBruto) $weight = $weight + ($quantity * $product->pesoBruto);

                $item->price = round($product->preco, 2);
                $item->listPrice = round($product->preco, 2);

                $stock   = $product->estoqueAtual;

                $freight = $zipcode->getFreight($postalCode, $weight);

                $shipping = new stdClass();
                $shipping->itemId = $item->id;
                $shipping->inventoryAvailable = $stock;
                $shipping->quantity = ($shipping->inventoryAvailable > $quantity) ? $quantity : $shipping->inventoryAvailable;
                $shipping->categories = array();
                if ($shipping->quantity > 0) {
                    $category = new stdClass();
                    if ($freight['price'] > 0 & $freight['time'] > 0) {
                        $category->id = "Transportadora";
                        $category->name = "Entrega Normal";
                        $category->shippingEstimate = $freight['time'] . 'bd';
                        $category->price = round($freight['price'], 2);
                        $category->scheduledDeliveries = array();

                    }
                    $shipping->categories = array(0 => $category);
                }
                $obj->shipmentInfos[] = $shipping;
            } else {
                unset($obj->items[$key]);
            }
        }
    }

    header('Content-Type: application/json');
    echo json_encode($obj);
}
?>