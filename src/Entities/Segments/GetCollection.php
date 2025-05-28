<?php

namespace OfflineAgency\LaravelEmailChef\Entities\Segments;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;
use Carbon\Carbon;

class GetCollection extends AbstractEntity
{
    public string $id;
    public int $list_id;
    public string $name;
    public int $match_count;
    public int $total_count;
    public Carbon $refresh_time;
}
