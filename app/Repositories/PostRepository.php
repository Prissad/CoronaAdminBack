<?php


namespace App\Repositories;


use App\Post;

class PostRepository
{
    private $model;

    public function __construct(Post $report)
    {
        $this->model = $report;
    }

    public function index()
    {
        return $this->model->all();
    }

    public function store(array $data)
    {
        // Log::info(print_r($request->all(),true)); yestalou fel laravel.log
        // dd($request->all()); yjiw preview fel body
        //dump and die

        return $this->model->create($data);

    }

    public function show($id)
    {
        return ($this->model->where('id', '=', $id)->first());
        //first retourne le premier, get retoure un tableau
    }

    public function update(array $data, $id)
    {
        // Log::info($id);
        $modelToUpdate=$this->model->where('id',$id)->firstOrFail();
        $modelToUpdate->update($data);
        return $modelToUpdate;
    }

    public function destroy($id)
    {
        $modelToDelete=$this->model->where('id',$id)->firstOrFail();
        return  $modelToDelete->delete();

    }

}
