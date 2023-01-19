<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Http\Interfaces\RepositoryInterface;


class Repository  implements RepositoryInterface
{
    protected $model;
    public function __construct(Model $model)
    {
        $this->model =$model; 
    }


    public function all()
    {
        return $this->model->all();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function edit(array $data,$id)
    {
        $record = $this->model->find($id);
        return $record->update($data);
    }

    public function delete($id)
    {
        return $this->model->delete();
    }

    public function show($id)
    {
        return $this->model->findOrFail();
    }
}
