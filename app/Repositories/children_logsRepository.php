<?php

namespace App\Repositories;

use App\Models\children_logs;
use App\Repositories\BaseRepository;

/**
 * Class children_logsRepository
 * @package App\Repositories
 * @version August 11, 2023, 10:26 pm WIB
*/

class children_logsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'key',
        'date',
        'total',
        'list_id',
        'failed_list_id'
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
        return children_logs::class;
    }
}
