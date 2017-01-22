<?php

/*
 * * azure project presents:
                                          _
                                         | |
 __,   __          ,_    _             _ | |
/  |  / / _|   |  /  |  |/    |  |  |_|/ |/ \_
\_/|_/ /_/  \_/|_/   |_/|__/   \/ \/  |__/\_/
        /|
        \|
				azure web
				version: 1.0a
				azure team
 * * be carefully.
 */

namespace Azure\Controllers\ADefault\APublic;

use Azure\Database\Adapter;
use Azure\Models\Json\Countries as JsonCountry;
use Azure\Models\Json\Payment as JsonPayment;
use Azure\Models\Json\Purse as JsonPurse;
use Azure\Types\Controller as ControllerType;
use stdClass;

/**
 * Class Inventory
 * @package Azure\Controllers\ADefault\APublic
 */
class Inventory extends ControllerType
{
    /**
     * function construct
     * create a controller for promos
     */

    function __construct()
    {

    }

    /**
     * function show
     * render and return content
     */
    function show()
    {
        $count = 0;
        $inventory_purse = [];
        $region_id = $_GET['inventory'];

        foreach (Adapter::secure_query("SELECT * FROM cms_shop_inventory WHERE region = :id", [':id' => $region_id]) as $row_a):
            $row_b = Adapter::fetch_object(Adapter::secure_query("SELECT * FROM cms_shop_payments_types WHERE id = :id LIMIT 1", [':id' => $row_a['payment_type']]));
            $payment_json[$count] = new JsonPayment($row_b->id, $row_b->name, $row_b->button, $row_b->image, 'online');
            $inventory_purse[$count] = new JsonPurse($row_a['id'], $row_a['name'], $row_a['description'], $row_a['credits_amount'], $row_a['price'], [0 => $row_a['categories']], $row_a['icon'], $row_a['region'], $payment_json);
            $count++;
        endforeach;

        $row_c = Adapter::fetch_array(Adapter::secure_query("SELECT * FROM cms_shop_countries WHERE country_code = :id LIMIT 1", [':id' => $region_id]));
        $country_json = new JsonCountry($row_c['country_id'], $row_c['country_name'], $row_c['country_locale'], $row_c['country_code']);

        $inventory_object = new stdClass();
        $inventory_object->country = $country_json;
        $inventory_object->paymentCategories = ['online'];
        $inventory_object->pricePoints = $inventory_purse;
        $inventory_object->doubleCredits = true;

        header('Content-type: application/json');
        return json_encode($inventory_object);
    }
}
