<?php

namespace OfflineAgency\LaravelEmailChef\Entities\Segments;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class DeleteSegments extends AbstractEntity
{
    public int $id;
    public string $status;
}