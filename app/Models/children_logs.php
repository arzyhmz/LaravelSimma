<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class children_logs
 * @package App\Models
 * @version August 11, 2023, 10:26 pm WIB
 *
 * @property string $key
 * @property string $date
 * @property integer $total
 * @property string $list_id
 * @property string $failed_list_id
 */
class children_logs extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'children_logs';
    
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
        'date' => 'string',
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
