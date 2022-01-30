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
                'slug' => strtolower($slug),
                'active' => $active,
            ]);
            $_SESSION['success']= 'Catergory created';
            redirect('dashboard/catergories');
        }
        $_SESSION['errors'] = $errors;
        redirect('catergories');
    }
    public function getEdit($id = null)
    {
       if($id === null){
           redirect('dashboard/categories');
       }
        $_SESSION['category_id'] = $id;
        view('backend/category/edit');
      unset($_SESSION['category_id']);
    }
    public function postEdit($id = null)
    {
        if($id === null){
            redirect('dashboard/categories');
        }
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
        try{
          $category = Category::find($id);
          $category->update([
              'title' => $title,
              'slug' => strtolower($slug),
              'active' => $active,
          ]);
            $_SESSION['success']= 'Catergory updated';
            redirect('dashboard/catergories');
        }catch(\Exception $e){
            $_SESSION['errors'] = ['message' => $e->getMessage()];
            redirect('dashboard/catergories');
        }
    }
}