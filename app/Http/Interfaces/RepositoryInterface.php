<?php

namespace App\Http\Interfaces;

interface RepositoryInterface
{
    public function all();

    public function create(array $data);

    public function edit(array $data,$id);

    public function delete($id);

    public function show($id);
} 