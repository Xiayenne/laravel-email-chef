<?php

namespace OfflineAgency\LaravelEmailChef\Entities\Segments;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;
use Carbon\Carbon;

class GetCollection extends AbstractEntity
{
    public ?string $id;
    public string $name;
    public string $description;
    public int $match_count;
    public int $total_count;
    public Carbon $last_refresh_time;
}
