<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function addCategory(Request $req)
    {
        $category = new Category();

        $category->name = $req->name;

        if(!$category->save()) {
            return response()->json([
                "success" => false,
                "message" => "Что-то пошло не так, попробуйте снова..."
            ], 400);
        }
        return response()->json([
            "success" => true,
            "message" => "Категория добавлена успешно!"
        ]);
    }
    public function deleteCategory(Request $req)
    {
        $category = Category::where('id', $req->id)->first();

        if (!$category) {
            return response()->json("Такой категории не существует.");
        }

        $category->delete();
        return response()->json("Категория удалена");
    }

    public function getCategory(Request $req)
    {
        return response()->json(Category::get());
    }
}
