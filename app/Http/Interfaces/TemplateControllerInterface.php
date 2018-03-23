<?php

namespace App\Http\Interfaces;
use Illuminate\Http\Request;

interface TemplateControllerInterface
{

    /**
     * Show all user's templates
     *
     */
    public function index();

    /**
     * Show template by ID
     */
    public function get($id);

    /**
     * Create
     */
    public function create(Request $request);

    /**
     * Update template
     */
    public function update($id, Request $request);

    /**
     * Delete template
     */
    public function delete($id);

}