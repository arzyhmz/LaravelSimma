<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class children
 * @package App\Models
 * @version August 11, 2023, 10:14 pm WIB
 *
 * @property string $partner_id
 * @property string $pledge_id
 * @property string $paid_thru
 * @property string $name
 * @property string $idn
 * @property string $status
 * @property string $message
 * @property string $udpate_date
 */
class children extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'childrens';
    
    protected $dates = ['deleted_at'];

    public $fillable = [
        'partner_id',
        'pledge_id',
        'paid_thru',
        'name',
        'idn',
        'status',
        'message',
        'udpate_date',
        'simma_id',
        'qontak_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'partner_id' => 'string',
        'pledge_id' => 'string',
        'paid_thru' => 'string',
        'name' => 'string',
        'idn' => 'string',
        'status' => 'string',
        'message' => 'string',
        'udpate_date' => 'date',
        'simma_id' => 'string',
        'qontak_id' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
