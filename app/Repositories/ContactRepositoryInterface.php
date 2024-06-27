<?php

namespace App\Repositories;

interface ContactRepositoryInterface {
    public function store($data);
    public function update($data);
}