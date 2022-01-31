<?php
namespace App\Controllers\Backend;
use App\Controllers\Controller;
use App\Models\Product;
use Respect\Validation\Validator;

class ProductController extends Controller {
    public function getIndex()
    {
        view('backend/product/index');
    }
    public function postIndex()
    {
        $validatior = new Validator();
        $errors = [];
        $title = $_POST['title'];
        $category_id = $_POST['catergory_id'];
        $slug = $this->slugify($_POST['title']);
        $description = $_POST['description'];
        $price = $_POST['price'];
        $sales_price = $_POST['sales_price'];
        $active = (int)$_POST['active'];
        $product_photo = $_FILES['product_photo'];
//validation
        if($validatior::length(2, 255)->validate($title) === false){
            $errors['title'] = 'Title length must be between 2 and 255';
        }
        if(strlen($description)<0){
            $errors['description'] = 'Description can not be empty';
        }
        if($validatior::numeric()->positive()->validate($price) === false){
          $errors['price'] = 'Price must be a positive value';
        }
        if($validatior::numeric()->positive()->validate($sales_price) === false) {
            $errors['sales_price'] = 'Sales Price must be a positive value';
        }
//        if($validatior::image()->validate($product_photo['name']) === false){
//            $errors['product_photo'] = 'Product Photo must be a valid image';
//        }
        if(empty($errors)){
            $product = Product::create([
                'title' => $title,
                'category_id' => $category_id,
                'slug' => $slug,
                'description' => $description,
                'price' => $price,
                'sales_price' => $sales_price,
                'active' => $active,
            ]);
            //profile_photo upload
            $file_name = 'product_'.time();
            $extension =explode('.', $product_photo['name']);
            $ext = end($extension);
            move_uploaded_file($product_photo['tmp_name'],'media/products/' . $file_name.'.'.$ext);
            $product->product_photo()->create([
               'image_path' => $file_name.'.'.$ext
            ]);

            $_SESSION['success']= 'Catergory created';
            redirect('dashboard/products');
        }
        $_SESSION['success']= $errors;
        redirect('dashboard/products');


    }
}