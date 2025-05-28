<?php

namespace OfflineAgency\LaravelEmailChef\Entities\Segments;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class UpdatedSegmentEntity extends AbstractEntity
{
    public string $id;
    public string $status;
}
