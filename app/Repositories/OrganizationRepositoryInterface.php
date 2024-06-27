<?php

namespace App\Repositories;

interface OrganizationRepositoryInterface {
    public function store($data);
    public function update($data);
    public function getFields($type , $organization_id);
    public function getFieldsContact($type , $contact_id);
}