<?php

namespace App\Http\Repositories;

use App\Models\Template;
use Illuminate\Support\Facades\Auth;

class TemplatesRepository extends BaseRepository 
{
    
    public function __construct(Template $model) 
    {
        $this->model = $model;
    }

    /**
     * Get all templates
     */
    public function all() 
    {
        return $this->model->where('user_id', Auth::id());
    }

    /**
     * Get template by ID
     */
    public function find($id)
    {
        return $this->model->where('user_id', Auth::id())->find($id);
    }

    /**
     * Create new template
     */
    public function create($data) 
    {
        $data['user_id'] = Auth::id();
        
        $model = $this->model();
        $item = (new $model())->create($data);

        return $item;
    }

    /**
     * Update template
     */
    public function update($id, $data)
    {
        
        $data['user_id'] = Auth::id();
        
        $item = $this->model->where('user_id', Auth::id())->find($id);    
        $item->fill($data);        
        $item->save();

        return $item;
    }

    /**
     * Delete template
     */
    public function delete($id)
    {
        $this->model->where('user_id', Auth::id())->find($id)->delete();
    }

}