<?php

namespace OfflineAgency\LaravelEmailChef\Entities\Segments;

use Carbon\Carbon;
use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class ContactsCount extends AbstractEntity
{
    public int $match_count;
    public int $total_count;
}
