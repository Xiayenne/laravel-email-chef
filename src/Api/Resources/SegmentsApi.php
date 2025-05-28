<?php

namespace OfflineAgency\LaravelEmailChef\Api\Resources;

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use OfflineAgency\LaravelEmailChef\Api\Api;
use OfflineAgency\LaravelEmailChef\Entities\Error;
use OfflineAgency\LaravelEmailChef\Entities\Segments\ContactsCount;
use OfflineAgency\LaravelEmailChef\Entities\Segments\GetCollection;
use OfflineAgency\LaravelEmailChef\Entities\Segments\GetInstance;
use OfflineAgency\LaravelEmailChef\Entities\Segments\CountSegments;
use OfflineAgency\LaravelEmailChef\Entities\Segments\CreatedSegmentEntity;
use OfflineAgency\LaravelEmailChef\Entities\Segments\UpdatedSegmentEntity;


class SegmentsApi extends Api
{
    public function getCollection( ?int $limit, ?int $offset)
    {
        $response = $this->get('segments?limit='.$limit.'offset='.$offset);

        if(!$response->success){
            return new Error($response -> data);
        }

        $collections = $response->data;
        
        $out = collect();
        foreach ($collections as $collection) {
            $out->push(new GetCollection($collection));
        }
        return $out;
    }

    public function getInstance(int $segment_id)
    {
        $response = $this->get('segments/'.$segment_id, [
            'segment_id' => $segment_id,
        ]);

        if(!$response->success){
            return new Error($response -> data);
        }

        $segments = $response->data;

        return new GetInstance($segments);

    }

    public function getCount(int $list_id)
    {
        $response = $this->get('list/'.$list_id.'/segments/count', [
            'list_id' => $list_id,
        ]);

        if(!$response->success){
            return new Error($response->data);
        }

        $count = $response->data;

        return new CountSegments($count);
    }

    public function getContactsCount(int $segment_id)
    {
        $response = $this->get('segments/'.$segment_id.'/contacts/count',[
            'segment_id' => $segment_id,
        ]);

        if(!$response->success){
            return new Error($response->data);
        }

        $sount_contact = $response->data;

        return new ContactsCount($sount_contact);
    }

    public function create(array $instance_in)
    {
        $validator = Validator::make($instance_in, [
            'list_id' => 'required',
            'logic' => 'required|string',
            'condition_groups' => 'array',
            'name' => 'required|string',
            'description' => 'string|nullable',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->post('contacts', [
            'instance_in' => array_merge($instance_in, []),
        ]);

        if (! $response->success) {
            return new Error($response->data);
        }

        $segment = $response->data;

        return new CreatedSegmentEntity($segment);
    }

    public function update(int $segment_id, array $instance_in = [])
    {
        $validator = Validator::make($instance_in, [
            'list_id' => 'required',
            'logic' => 'required|string',
            'condition_groups' => 'array',
            'name' => 'required|string',
            'description' => 'string|nullable',
        ]);

        $response = $this->put('segments/'.$segment_id, [
            'instance_in' => array_merge($instance_in, []),
        ]);

        if (! $response->success) {
            return new Error($response->data);
        }

        $segment = $response->data;

        return new UpdatedSegmentEntity($segment);
    }

    public function delete(int $segment_id)
    {
        $response = $this->destroy('segments/'.$segment_id);

        if (! $response->success) {
            return new Error($response->data);
        }

        return 'Segment #'.$segment_id.' deleted';
    }
}
