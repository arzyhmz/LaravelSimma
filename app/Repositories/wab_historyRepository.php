<?php

namespace App\Repositories;

use App\Models\wab_history;
use App\Repositories\BaseRepository;

/**
 * Class wab_historyRepository
 * @package App\Repositories
 * @version July 27, 2023, 7:27 am WIB
*/

class wab_historyRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'partner_id',
        'room_id',
        'chat',
        'status',
        'update_date'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return wab_history::class;
    }
}
