<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class chat_logs
 * @package App\Models
 * @version July 29, 2023, 9:04 am WIB
 *
 * @property string $key
 * @property string $date
 * @property integer $total
 * @property string $list_id
 * @property string $failed_list_id
 */
class chat_logs extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'chat_logs';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'key',
        'date',
        'total',
        'list_id',
        'failed_list_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'key' => 'string',
        'date' => 'date',
        'total' => 'integer',
        'list_id' => 'string',
        'failed_list_id' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
