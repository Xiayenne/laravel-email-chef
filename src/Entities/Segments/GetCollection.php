<?php

namespace OfflineAgency\LaravelEmailChef\Entities\Segments;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;
use Carbon\Carbon;

class GetCollection extends AbstractEntity
{
    public ?string $id = '';
    public string $name = '';
    public string $description = '';
    public int $match_count = 0;
    public int $total_count = 0;
    public string $last_refresh_time = '';
}
