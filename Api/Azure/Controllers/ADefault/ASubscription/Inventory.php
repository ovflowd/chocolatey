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

namespace Azure\Controllers\ADefault\ASubscription;

use Azure\Database\Adapter;
use Azure\Models\Json\Countries as JsonCountry;
use Azure\Models\Json\Payment as JsonPayment;
use Azure\Models\Json\Subscription as JsonSubscription;
use Azure\Types\Controller as ControllerType;
use Azure\View\Misc;
use stdClass;

/**
 * Class Inventory
 * @package Azure\Controllers\ADefault\ASubscription
 */
class Inventory extends ControllerType
{
    /**
     * function construct
     * create a controller for shop inventory
     */

    function __construct()
    {

    }

    /**
     * function show
     * render and return content
     * @return string
     */
    function show()
    {
        $count = 0;
        $inventory_subscribe = [];
        $region_id = Misc::escape_text($_GET['inventory']);

        foreach (Adapter::secure_query("SELECT * FROM cms_shop_subscriptions WHERE region = :id", [':id' => $region_id]) as $row_a):
            $row_b = Adapter::fetch_object(Adapter::secure_query("SELECT * FROM cms_shop_payments_types WHERE id = :id LIMIT 1", [':id' => $row_a['payment_type']]));
            $payment_json[$count] = new JsonPayment($row_b->id, $row_b->name, $row_b->button, $row_b->image, 'subscription');
            $inventory_subscribe[$count] = new JsonSubscription($row_a['id'], $row_a['name'], $row_a['description'], $row_a['credits_amount'], $row_a['price'], $row_a['type'], $row_a['icon'], $payment_json);
            $count++;
        endforeach;

        $count = 0;
        $countries = [];

        foreach (Adapter::query("SELECT * FROM cms_shop_countries") as $row_a)
            $countries[$count++] = new JsonCountry($row_a['country_id'], $row_a['country_name'], $row_a['country_locale'], $row_a['country_code']);

        $row_c = Adapter::fetch_array(Adapter::secure_query("SELECT * FROM cms_shop_countries WHERE country_code = :id LIMIT 1", [':id' => $region_id]));
        $country_json = new JsonCountry($row_c['country_id'], $row_c['country_name'], $row_c['country_locale'], $row_c['country_code']);

        $subscriptions_object = new stdClass();
        $subscriptions_object->selectedCountry = $country_json;
        $subscriptions_object->countries = $countries;
        $subscriptions_object->items = $inventory_subscribe;

        header('Content-type: application/json');
        return json_encode($subscriptions_object);
    }
}
