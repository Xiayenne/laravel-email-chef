<?php

namespace OfflineAgency\LaravelEmailChef\Entities\Segments;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class UpdatedSegmentEntity extends AbstractEntity
{
    public int $id;
    public string $status;
}
