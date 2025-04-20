<?php
namespace App\Service;

use App\Models\Menu;

class MenuService {
    public function add(array $data): Menu
    {
        $position = new Menu;
        $position->name =  $data['name'];
        $position->content =   $data['content'];
        $position->description =  $data['description'];
        $position->price =   $data['price'];

        return $position;
    }

    public function update(Menu $position, array $data)
    {
        foreach($data as $key => $value){
            if ($data[$key] != null && $data[$key] != '' && $data[$key] != 'null') {
                $position->$key = $value;
            }
        }
    }
}
