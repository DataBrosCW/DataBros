<?php

class FeedController extends Controller
{
    public function index()
    {
        $this->render('feed');
    }

    public function preferences()
    {
        $this->render('feed-preferences');
    }

}