<?php
namespace App\Controllers\Backend;
use App\Controllers\Controller;
use App\Models\Category;
use Respect\Validation\Validator;

class CategoryController extends Controller {
    public function getIndex()
    {
        view('backend/category/index');
    }
    public function postIndex()
    {
        $validatior = new Validator();
        $errors = [];
        $title = $_POST['title'];
        $slug = $_POST['slug'];
        $active = $_POST['active'];
//validation
        if($validatior::alpha()->validate($title) === false){
            $errors['title'] = 'Title can only content alphabets';
        }
        if($validatior::slug()->validate($slug) === false){
            $errors['slug'] = 'Slug must be a valid slug';
        }
        if(empty($errors)) {
            Category::create([
                'title' => $title,
                'slug' => $slug,
                'active' => $active,
            ]);
        }
    }
}