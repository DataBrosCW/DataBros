<?php

class CategoriesController extends Controller
{
    /**
     * All categories
     */
    public function index()
    {
        $this->render('categories');
    }

    /**
     * Display a specific one
     */
    public function show()
    {
        $this->render('category');
    }

}