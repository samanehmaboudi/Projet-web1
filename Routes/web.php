<?php 

use App\Routes\Route;
use App\Controllers\HomeController;
use App\Controllers\StampController;
use App\Controllers\WelcomeController;
use App\Controllers\AdminController;
use App\Controllers\AuthController;

// Route d'accueil principale (home)
Route::get('/', [new HomeController(), 'index']);
Route::get('home', [new HomeController(), 'index']);
Route::get('accueil', [new HomeController(), 'index']);

// Authentification (tout centralisé dans AuthController)
Route::get('login', [new AuthController(), 'login']);
Route::post('login', [new AuthController(), 'login']);

Route::get('register', [new AuthController(), 'register']);
Route::post('register', [new AuthController(), 'register']);

Route::get('register-admin', [new AuthController(), 'registerAdmin']);
Route::post('register-admin', [new AuthController(), 'registerAdmin']);

Route::get('logout', [new AuthController(), 'logout']);

Route::get('reset-password', [new AuthController(), 'resetPassword']);
Route::post('reset-password', [new AuthController(), 'resetPassword']);

// Pages protégées
Route::get('welcome', [new WelcomeController(), 'welcome']);
Route::get('dashboard', [new AdminController(), 'dashboard']);

// Admin - Gestion des utilisateurs
Route::get('admin-users', [new AdminController(), 'listUsers']);
Route::get('edit-user', [new AdminController(), 'editUser']);
Route::post('edit-user', [new AdminController(), 'editUser']);
Route::get('delete-user', [new AdminController(), 'deleteUser']);

// Catalogue
Route::get('catalogue', [new StampController(), 'catalogue']);
Route::get('fiche-produit', [new StampController(), 'ficheProduit']);
