<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Http\Repositories\TemplatesRepository;


class TemplateController extends Controller
{
    
    private $templatesRepository;
    
    /**
     * Create a new controller instance.
     *
     */
    public function __construct(TemplatesRepository $templatesRepository)
    {
        $this->templatesRepository = $templatesRepository;
    }

    /**
     * Show all user's templates
     *
     */
    public function index()
    {
        return $this->templatesRepository->all()->get();
    }

    /**
     * Show template by ID
     */
    public function get($id)
    {
        return $this->templatesRepository->find($id);
    }

    /**
     * Create
     */
    public function create(Request $request)
    {
        
        //Алиас должен быть уникален для пользователя
        $this->validate($request, [
            'alias'     => ['required', 'alpha_dash', 'max:16',
                Rule::unique('templates')->where(function($query) {
                    $query->where('user_id', Auth::id());
                })],
        ]);

        $data = [
            'alias' => $request['alias'],
            'title' => $request['title'],
            'text'  => $request['text'],
        ];

        return $this->templatesRepository->create($data);

    }

    /**
     * Update template
     */
    public function update($id, Request $request)
    {
        
        $this->validate($request, [
            'alias'     => ['required', 'alpha_dash', 'max:16',
                Rule::unique('templates')->ignore($id)->where(function($query) {
                    $query->where('user_id', Auth::id());
                })],
        ]);

        $data = [
            'alias' => $request['alias'],
            'title' => $request['title'],
            'text'  => $request['text'],
        ];
        
        return $this->templatesRepository->update($id, $data);
    }

    /**
     * Delete template
     */
    public function delete($id)
    {
        $this->templatesRepository->delete($id);
    }
}
