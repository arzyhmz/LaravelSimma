<?php

namespace App\Repositories;

use App\Models\logs;
use App\Repositories\BaseRepository;

/**
 * Class logsRepository
 * @package App\Repositories
 * @version July 6, 2023, 1:07 am UTC
*/

class logsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'date',
        'key',
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
        return logs::class;
    }
}
