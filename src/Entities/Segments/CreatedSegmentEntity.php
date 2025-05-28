<?php

namespace OfflineAgency\LaravelEmailChef\Entities\Segments;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class CreatedSegmentEntity extends AbstractEntity
{
    public string $id;
    public string $status;
}
