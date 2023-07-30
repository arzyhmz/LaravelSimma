<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class wab_history
 * @package App\Models
 * @version July 27, 2023, 7:27 am WIB
 *
 * @property string $partner_id
 * @property string $room_id
 * @property string $chat
 * @property string $status
 * @property string $update_date
 */
class wab_history extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'wab_histories';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'partner_id',
        'room_id',
        'chat',
        'status',
        'update_date'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'partner_id' => 'string',
        'room_id' => 'string',
        'chat' => 'string',
        'status' => 'string',
        'update_date' => 'date'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
