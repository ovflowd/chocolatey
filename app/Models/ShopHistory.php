<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

/**
 * Class ShopHistory.
 *
 * @property int transactionId
 */
class ShopHistory extends ChocolateyModel
{
    use Eloquence, Mappable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'chocolatey_shop_history';

    /**
     * Primary Key of the Table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that will be mapped.
     *
     * @var array
     */
    protected $maps = ['transactionSystemName' => 'payment_method', 'transactionId' => 'id'];

    /**
     * The Appender(s) of the Model.
     *
     * @var array
     */
    protected $appends = ['creationTime', 'transactionSystemName', 'credits', 'price', 'transactionId', 'product'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at', 'approved_by', 'user_id', 'item_id'];

    /**
     * Get Creation Time Attribute.
     *
     * @return string
     */
    public function getCreationTimeAttribute(): string
    {
        return date('Y-m-d', strtotime($this->attributes['created_at'])).'T'.
            date('H:i:s.ZZZZ+ZZZZ', strtotime($this->attributes['created_at']));
    }

    /**
     * Get Payment Method Name.
     *
     * @return string
     */
    public function getTransactionSystemNameAttribute(): string
    {
        return PaymentMethod::find($this->attributes['payment_method'])->name;
    }

    /**
     * Get Transaction Id.
     *
     * @return int
     */
    public function getTransactionIdAttribute(): int
    {
        return $this->attributes['id'];
    }

    /**
     * Get Amount of Given Credits.
     *
     * @return int
     */
    public function getCreditsAttribute(): int
    {
        return DB::table('chocolatey_shop_items')->where('id', $this->attributes['item_id'])->first()->creditAmount;
    }

    /**
     * Get Product Attribute.
     *
     * @return mixed|object|array
     */
    public function getProductAttribute()
    {
        return DB::table('chocolatey_shop_items')->where('id', $this->attributes['item_id'])->first(['name', 'description']);
    }

    /**
     * Get Price Attribute.
     *
     * @return string
     */
    public function getPriceAttribute(): string
    {
        return DB::table('chocolatey_shop_items')->where('id', $this->attributes['item_id'])->first()->price;
    }

    /**
     * Store a new Purchase.
     *
     * @param int $paymentMethod
     * @param int $userId
     * @param int $itemId
     *
     * @return ShopHistory
     */
    public function store(int $paymentMethod, int $userId, int $itemId): ShopHistory
    {
        $this->attributes['payment_method'] = $paymentMethod;
        $this->attributes['user_id'] = $userId;
        $this->attributes['item_id'] = $itemId;

        $this->save();

        return $this;
    }
}
