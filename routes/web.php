<?php
use App\Livewire\Auth\Login;

use App\Livewire\Auth\Register;
use Illuminate\Support\Facades\Route;
use App\Livewire\Profile\Account;

use App\Livewire\Main\Cart\CartList;
use App\Livewire\Main\Landing\Index;
use App\Livewire\Admin\Brands\Brands;
use App\Livewire\Admin\Sliders\Sliders;
use App\Livewire\Main\Products\Product;
use App\Livewire\Admin\Brands\BrandsAdd;
use App\Livewire\Admin\Brands\BrandsEdit;
use App\Livewire\Admin\Products\Products;
use App\Livewire\Admin\Settings\Settings;
use App\Livewire\Admin\Sliders\SlidersAdd;
use App\Livewire\Main\Categories\Category;
use App\Livewire\Admin\Dashboard\Dashboard;
use App\Livewire\Admin\Sliders\SlidersEdit;
use App\Livewire\Admin\Products\ProductsAdd;
use App\Livewire\Admin\Categories\Categories;
use App\Livewire\Admin\Products\ProductsEdit;
use App\Livewire\Admin\Categories\CategoriesAdd;
use App\Livewire\Admin\Categories\CategoriesEdit;
use App\Livewire\Main\Categories\Categories as MainCategories;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/





//Main Routes
Route::get('/', Index::class)->name('index');

Route::get('/logout', function () {
    Auth::logout();

    return redirect('/');
});

Route::get('/account', Account::class)->name('account')->middleware('auth');

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
   
    //Dashboard Routes
    Route::prefix('dashboard')->group(function () {
        Route::get('/', Dashboard::class)->name('admin.dashboard');
    });
   
    //Categories Routes
    Route::prefix('categories')->group(function () {
        Route::get('/', Categories::class)->name('admin.categories');
        Route::get('/add', CategoriesAdd::class)->name('admin.categories.add');
        Route::get('/edit/{slug}/{id}', CategoriesEdit::class)->name('admin.categories.edit');
    });

    // Brands Routes
    Route::prefix('brands')->group(function () {
        Route::get('/', Brands::class)->name('admin.brands');
        Route::get('/add', BrandsAdd::class)->name('admin.brands.add');
        Route::get('/edit/{slug}/{id}', BrandsEdit::class)->name('admin.brands.edit');
    });
    
    // Products Routes
    Route::prefix('products')->group(function () {
        Route::get('/', Products::class)->name('admin.products');
        Route::get('/add', ProductsAdd::class)->name('admin.products.add');
        Route::get('/edit/{slug}/{id}', ProductsEdit::class)->name('admin.products.edit');
    });

    // Sliders Routes
    Route::prefix('sliders')->group(function () {
        Route::get('/', Sliders::class)->name('admin.sliders');
        Route::get('/add', SlidersAdd::class)->name('admin.sliders.add');
        Route::get('/edit/{id}', SlidersEdit::class)->name('admin.sliders.edit');
    });

    // Settings Routes
    Route::prefix('settings')->group(function () {
        Route::get('/', Settings::class)->name('admin.settings');
    });
});

//Auth Routes
Route::prefix('auth')->middleware(['guest'])->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});

//? Contents
Route::prefix('main')->group(function () {
    Route::prefix('categories')->group(function () {
        Route::get('/', MainCategories::class)->name('main.categories'); //view all categories
        Route::get('/{id}/{slug}', Category::class)->name('main.category'); //view selected category
    });
    Route::prefix('product')->group(function () {
        // Route::get('/', MainCategories::class)->name('main.categories'); //view all categories
        Route::get('/{id}/{slug}', Product::class)->name('main.product'); //view selected product
    });
    
    
    Route::prefix('cart')->group(function () {
        Route::get('/', CartList::class)->name('main.cart'); //view all wishlist
    });
});