<?php

namespace App\Models;

/**
 * Class RoomItem.
 */
class RoomItem extends ChocolateyModel
{
    /**
     * Disable Timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'items';

    /**
     * Primary Key of the Table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Store a RoomItem.
     *
     * @param int    $userId
     * @param int    $roomId
     * @param int    $itemId
     * @param int    $xPosition
     * @param int    $yPosition
     * @param string $zPosition
     * @param int    $rotation
     * @param string $extraData
     * @param string $wallPosition
     *
     * @return RoomItem
     */
    public function store(int $userId, int $roomId, int $itemId, int $xPosition, int $yPosition, string $zPosition, int $rotation, string $extraData, string $wallPosition = ''): RoomItem
    {
        $this->attributes['user_id'] = $userId;
        $this->attributes['room_id'] = $roomId;
        $this->attributes['item_id'] = $itemId;
        $this->attributes['x'] = $xPosition;
        $this->attributes['y'] = $yPosition;
        $this->attributes['z'] = $zPosition;
        $this->attributes['rot'] = $rotation;
        $this->attributes['extra_data'] = $extraData;
        $this->timestamps = false;

        if (!empty($wallPosition)) {
            $this->attributes['wall_pos'] = $wallPosition;
        }

        $this->save();

        return $this;
    }
}
