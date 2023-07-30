<?php

namespace App\Repositories;

use App\Models\chat_logs;
use App\Repositories\BaseRepository;

/**
 * Class chat_logsRepository
 * @package App\Repositories
 * @version July 29, 2023, 9:04 am WIB
*/

class chat_logsRepository extends BaseRepository
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
        return chat_logs::class;
    }
}
