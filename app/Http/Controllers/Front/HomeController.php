<?php

namespace App\Http\Controllers\Front;

use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Language;
class HomeController
{
    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepo;

    /**
     * HomeController constructor.
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepo = $categoryRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //$cat1 = $this->categoryRepo->findCategoryById(2);
        //$cat2 = $this->categoryRepo->findCategoryById(3);
        $make = $this->categoryRepo->rootCategories('name', 'asc');
        $orders = 0;
        /*if(auth()->check()){
            $orders = getUserOrders($user_id);
        }*/
        //dd($make);
        //return view('front.index', compact('cat1', 'cat2', 'make'));
        return view('front.index', compact('make'));
    }
    public function language($slug = false)
    {
        if(!$slug || empty($slug)){
            $slug = 'en';
        }
        elseif(!in_array($slug, ['en', 'fr'])){
            $slug = 'en';
        }
        session()->forget('language_phrases');
        $language = Language::where('code', '=', $slug)->first();
        session()->put('language_phrases', json_decode($language->phrases));
        \Session::put('user_lang', $slug);
        return redirect()->back();
    }
}
