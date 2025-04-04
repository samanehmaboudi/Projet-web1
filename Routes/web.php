<?php

use App\Routes\Route;

//Page d'accueil
Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index');
Route::get('accueil', 'HomeController@index');
Route::get('stamps', 'StampController@index'); 

// Authentification
Route::get('login', 'AuthController@login');
Route::post('login', 'AuthController@login');

Route::get('register', 'AuthController@register');
Route::post('register', 'AuthController@register');

Route::get('register-admin', 'AuthController@registerAdmin');
Route::post('register-admin', 'AuthController@registerAdmin');

Route::get('logout', 'AuthController@logout');

Route::get('reset-password', 'AuthController@resetPassword');
Route::post('reset-password', 'AuthController@resetPassword');

// Page après connexion
Route::get('welcome', 'WelcomeController@welcome');

// Catalogue (stamps)
Route::get('catalogue', 'StampController@catalogue');
Route::get('fiche-produit', 'StampController@ficheProduit');


//Administration (privileges requis)
Route::get('dashboard', 'AdminController@dashboard');
Route::get('superadmin-dashboard', 'SuperAdminController@dashboard');
Route::get('make-admin', 'AdminController@makeAdmin');


Route::get('admin-users', 'AdminController@listUsers');
Route::get('edit-user', 'AdminController@editUser');
Route::post('edit-user', 'AdminController@editUser');
Route::get('delete-user', 'AdminController@deleteUser');

// Utilisateur connecté (profil)
Route::get('profil', 'UserController@profil');
Route::post('update-user', 'UserController@update');


Route::get('user/create', 'UserController@create');
Route::post('user/create', 'UserController@store');


Route::get('admin-stamps', 'StampController@adminStamps');
Route::get('create-stamp', 'StampController@create');
Route::post('create-stamp', 'StampController@store');
Route::get('create-stamp', 'StampController@create');
Route::post('create-stamp', 'StampController@store');
Route::get('edit-stamp', 'StampController@edit');
Route::post('edit-stamp', 'StampController@update');
Route::get('delete-stamp', 'StampController@delete');
Route::get('show-stamp', 'StampController@show');



