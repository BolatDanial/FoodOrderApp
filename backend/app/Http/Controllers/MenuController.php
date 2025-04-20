<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Service\MenuService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenuController
{
    protected $service;
    public function __construct(MenuService $menuService)
    {
        $this->service = $menuService;
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|required',
            'description' => 'string|required',
            'content' => 'string|required',
            'price' => 'numeric|required',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        $position = $this->service->add($request->only('name', 'content', 'description', 'price'));
        $position->save();

        return response($position, 201);
    }

    public function getAll()
    {
        $positions = Menu::all();

        return response($positions, 200);
    }

    public function getById($id)
    {
        $position = Menu::where('id', $id)->first();

        return response($position, 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'description' => 'string',
            'content' => 'string',
            'price' => 'numeric',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        $position = Menu::where('id', $id)->first();
        $this->service->update($position, $request->only('name', 'content', 'description', 'price'));
        $position->save();

        return response(["updatedID" => $position->id], 200);
    }

    public function delete($id)
    {
        $res = Menu::where('id', $id)->first()->delete();

        return response(["deletedID" => $res], 200);
    }
}
