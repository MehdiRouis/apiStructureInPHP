<?php

/* {GET} */

// Homepage
$router->get('/', 'Index#getHomepage', 'homePage');

//Get all news of the website
$router->get('/community/news/all', 'Community#getAllNews', 'allNews');

//Get all settings of the project
$router->get('/settings/all', 'Settings#getSettings', 'allSettings');

// Get news with the id filter
$router->get('/community/news/:id', 'Community#getNew', 'getNew')->with('id','[0-9]+');


$router->post('/community/news/add', 'Community#postNew', 'postNew');


//$router->get('/user/profile/:id', 'Company#getCompany', 'companyprofile')->with('id','[0-9]+');
