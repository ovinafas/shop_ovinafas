<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contracts\CategoryContract;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryContract $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function show($slug)
    {
        $category = $this->categoryRepository->findBySlug($slug);

        return view('front.pages.category', compact('category'));
    }
    
}
