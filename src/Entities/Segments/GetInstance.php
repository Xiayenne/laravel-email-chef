<?php

namespace OfflineAgency\LaravelEmailChef\Entities\Segments;

use Carbon\Carbon;
use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class GetInstance extends AbstractEntity
{
    public int $id;
    public int $list_id;
    public ?string $logic;
    public ?array $condition_groups;
    public string $name;
    public ?string $description;

}