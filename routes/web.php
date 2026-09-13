<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShippingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginHistoryController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ProductItemController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\RiderController;
use App\Http\Controllers\StoreSettingController;







// Auth::routes();

Route::get('/', [HomeController::class, 'home'])->name('home');


// ใหม่ใฟม่

// Route::get('/login', [LoginController::class, 'indexLogin'])->name('index.login');
// Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'indexLogin'])->name('index.login');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
});
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});


// Route::middleware('guest')->group(function () {
//     Route::get('/login', [LoginController::class, 'indexLogin'])->name('index.login');
//     Route::post('/login', [LoginController::class, 'login'])->name('login');
//     Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
//     Route::post('/register', [RegisterController::class, 'register']);
// });




// ===========================
// Home / Dashboard
// ===========================
// Route::get('/', [ProductController::class, 'home'])->name('home');
Route::get('/product-home', [ProductController::class, 'home'])->name('product.home');
Route::get('/admin/home', [AdminController::class, 'home'])->name('admin.home')->middleware('is_admin');
Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.index');



// ===========================
// Product Items (สินค้า Master)
// ===========================
// Route::get('/product-items/create', [ProductItemController::class, 'create'])->name('product-items.create');
Route::post('/product-items', [ProductItemController::class, 'store'])->name('product-items.store');
// Route::get('/product-items/{id}', [ProductItemController::class, 'show'])->name('product-items.show');
Route::get('/products/add', [ProductItemController::class, 'create'])->name('products.add');
// ใหม่ บน Route::get('/products/add', [ProductItemController::class, 'create'])->name('products.add');
Route::get('/add-data', [ProductItemController::class, 'create'])->name('add.data');
Route::get('/productlist', [ProductItemController::class, 'index'])->name('products.list');
Route::delete('/product-items/{id}', [ProductItemController::class, 'destroy'])->name('product-items.destroy');
Route::put('/product-items/{id}', [ProductItemController::class, 'update'])->name('product-items.update');
Route::get('/product-items/{id}', [ProductItemController::class, 'show'])->name('product-items.show');

Route::get('/brands-by-category/{category}', [ProductItemController::class,'getBrandsByCategory']);
// Route::get('/suppliers-by-brand/{brand}', [ProductItemController::class,'getSuppliersByBrand']);
//ใหม่
Route::get('/suppliers-by-brand', [ProductItemController::class, 'getSuppliersByBrand']);


// ===========================
// Products (สินค้า POS)
// ===========================
// Route::get('/add-data', [ProductController::class, 'add'])->name('add.data');
// Route::get('/products/add', [ProductController::class, 'add'])->name('products.add'); เก่า เก่า
// เก่ากลาง
Route::get('/products/list', [ProductController::class, 'productList'])->name('products.list');
// Route::post('/products/add-from-list', [ProductController::class, 'addProductFromList'])->name('products.addFromList');
Route::get('/productlist', [ProductController::class, 'index'])->name('product.list');
// Route::post('/products/add-from-list', [ProductController::class, 'addProductFromList'])->name('products.addFromList');
// Route::post('/products/add', [ProductController::class, 'addProductToPOS'])->name('products.addProductToPOS');
Route::delete('/products/remove/{id}', [ProductController::class, 'removeFromPOS'])->name('products.removeFromPOS');
// Route::get('/ajax/all-products', [ProductController::class,'getAllProducts']);
// Route::post('/products/import-pos', [ProductController::class,'importToPOS'])->name('products.importToPOS');
Route::get('/ajax/all-products',[ProductController::class,'allProducts']);
Route::post('/products/import',[ProductController::class,'importToPOS'])->name('products.importToPOS');


// ใหม่
// แสดงฟอร์มเพิ่ม ProductItem
// Route::get('/products/add', [ProductItemController::class, 'create'])->name('products.add'); ล่าสุด เกิดอะไรผิดcomเอาออก

// บันทึก ProductItem
Route::post('/product-items', [ProductItemController::class, 'store'])->name('product-items.store');

// แสดง product list (สำหรับเลือกสินค้ามาเพิ่มใน POS)
// Route::get('/products/list', [ProductController::class, 'productList'])->name('products.list');

// เพิ่มจาก productlist → products
// Route::post('/products/add-to-pos', [ProductController::class, 'addProductToPOS'])->name('products.addToPOS');
// Route::post('/products/add-to-pos', [ProductController::class, 'addProductToPOS'])->name('products.addProductToPOS');
Route::post('/products/addProductToPOS', [ProductController::class, 'addProductToPOS'])->name('products.addProductToPOS');
// Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

// แสดงข้อมูลสินค้า (AJAX)
Route::get('/products/{product}', [ProductController::class, 'edit'])->name('products.edit');
// อัปเดตสินค้า
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
// Route::resource('product-items', ProductController::class);
// Route::resource('product-items', ProductItemController::class);





// ===========================
// AJAX Routes
// ===========================
// เก่า
// Route::get('/ajax/brands/{category_id}', [ProductController::class, 'getBrandsByCategory']);
// Route::get('/ajax/products', [ProductController::class, 'getProducts']);
// // ดึง Brands ตาม Category
// Route::get('/ajax/brands/{category}', [ProductController::class, 'getBrandsByCategory']);

// ดึง Suppliers ตาม Category + Brand
Route::get('/ajax/suppliers', [ProductController::class, 'getSuppliersByCategoryBrand']);

// ดึง Products ตาม Category + Brand + Supplier
Route::get('/ajax/products', [ProductController::class, 'getProductsFiltered']);
// ใหม่
Route::get('/ajax/brands/{category}', [ProductItemController::class, 'getBrandsByCategory']);
Route::get('/ajax/suppliers', [ProductItemController::class, 'getSuppliers']);
Route::get('/ajax/products', [ProductItemController::class, 'getProducts']);

// ===========================
// Orders / POS
// ===========================

Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
Route::post('/save-selection', [OrderController::class, 'saveSelection'])->name('save.selection');
Route::get('/sale', [OrderController::class, 'index'])->name('sale');
Route::get('/checkout/{sellDataId}', [HomeController::class, 'showCheckout'])->name('checkout');
Route::get('/admin/order/proof', [OrderController::class, 'proofList'])->name('admin.order.proof');
Route::get('/admin/order/{id}/proof/show', [OrderController::class, 'showProof'])->name('admin.order.proof.show');

Route::get('/orders/{id}/pdf', [OrderController::class, 'pdf'])->name('orders.pdf');

// ===========================
// Stock
// ===========================
// Route::get('/stockdata', [HomeController::class, 'stockdata'])->name('stockdata');
Route::post('/stock/increase', [StockController::class, 'increase'])->name('stock.increase');
// Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
Route::get('/stock', [StockController::class, 'stock'])->name('stock');
// Route::get('/stock/list', [StockController::class, 'stock'])->name('stock.list');
Route::get('/stock2', [StockController::class, 'stock2'])->name('stock2');
Route::post('/stock/add', [StockController::class, 'addStock'])->name('stock.add');


// ===========================
// Customer
// ===========================
Route::middleware(['auth'])->group(function () {
Route::get('/customer', [CustomerController::class, 'indexCus'])->name('customer'); // แสดงรายการลูกค้า
Route::post('/customer/store', [CustomerController::class, 'store'])->name('customer.store'); // บันทึกลูกค้าใหม่
Route::get('/customer/{id}/edit', [CustomerController::class, 'edit'])->name('customer.edit'); // แสดงฟอร์มแก้ไข
Route::put('/customer/{customer}', [CustomerController::class, 'update'])->name('customer.update');
Route::delete('/customer/{customer}', [CustomerController::class, 'destroy'])->name('customer.destroy');
Route::get('/check-customer', [CustomerController::class, 'checkPhone']);
});

// ===========================
// Admin
// ===========================
Route::middleware(['auth', 'is_admin'])->group(function () {

Route::get('/adminstock', [AdminController::class, 'stockmove'])->name('adminstock');
Route::get('/adminstock/export', [AdminController::class, 'exportStockMovements'])->name('adminstock.export');
Route::get('/admin/customer-orders', [CustomerController::class, 'viewOrders'])->name('customer.orders');
Route::get('/login-history', [LoginHistoryController::class, 'showLoginHistory'])->name('admin.loginHistory');
Route::get('/admin/orders-summary',[AdminController::class, 'ordersSummary'])->name('orders-summary');
Route::get('/admin/orders/pending', [AdminController::class, 'pendingOrders'])->name('admin.orders.pending');

Route::get('/admin/orders/{order}',[AdminController::class, 'showOrder'])->name('admin.orders.show');
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::get('/admin/home', [AdminController::class, 'shipping'])->name('admin.shipping');
Route::post('/admin/orders/print', [AdminController::class, 'bulkPrint'])->name('admin.orders.print');


//จัดการสิทธิ์
Route::get('/admin/checkuser', [AdminController::class,'checkUsers'])->name('admin.checkuser');

Route::post('/admin/users/{id}/make-rider', [AdminController::class,'makeRider'])->name('admin.makeRider');
Route::post('/admin/users/{id}/remove-rider', [AdminController::class,'removeRider'])->name('admin.removeRider');

Route::post('/admin/users/{id}/make-admin', [AdminController::class,'makeAdmin'])->name('admin.makeAdmin');
Route::post('/admin/users/{id}/remove-admin', [AdminController::class,'removeAdmin'])->name('admin.removeAdmin');
// Route::get('/adminsale', [adminController::class, 'index']);
// Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');


//รูป
// Route::get('/admin/order/{id}/proof', [AdminController::class, 'showProof'])->name('admin.order.proof');
});


// Route::middleware(['auth'])->group(function () {
//     Route::get('/rider', function () {
//         return view('rider.dashboard');
//     })->name('rider.dashboard');
// });
Route::middleware(['auth'])->group(function () {

    Route::get('/rider', [RiderController::class,'dashboard'])
        ->name('rider.dashboard');

    // ดูรายละเอียดออเดอร์
    Route::get('/rider/order/{id}', [RiderController::class,'showOrder'])
        ->name('rider.order.show');

    // ยืนยันการจัดส่ง + อัปโหลดรูป
    Route::post('/rider/order/{id}/complete', [RiderController::class,'completeOrder'])
        ->name('rider.order.complete');

});


// ===========================
// Coil Data
// ===========================
// Route::get('/coildata', [HomeController::class, 'coildata'])->name('coildata');
// Route::resource('/coil',CoilController::class);
// Route::resource('/stockcoil',CoilstockController::class);



// ===========================
// Payment
// ===========================
// Route::get('/payment', function () {
//     return view('payment');
// })->name('payment');
// Route::get('/payment/{order}', [PaymentController::class, 'show'])->name('payment.show');



// ===========================
// Cart page
// ===========================
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/check-customer', [CartController::class, 'checkCustomer'])->name('cart.checkCustomer');
// พักตะกร้าไว้
// Route::post('/cart/hold', [CartController::class, 'holdCart'])->name('cart.hold');
// // กู้ตะกร้าที่พักไว้
// Route::post('/cart/restore/{key}', [CartController::class, 'restoreCart'])->name('cart.restore');
// Route::get('/cart', [CartController::class, 'showCart'])->name('cart');




// ===========================
// Shipping
// ===========================
// Route::get('/shippingblade', [ShippingController::class, 'shipping'])->name('');
Route::get('/shippingblade', [ShippingController::class, 'shipping'])->name('shippingblade');
Route::put('/shippingblade/{id}', [ShippingController::class, 'updateStatus'])->name('shipping.update');
Route::get('/shipping/order-details/{order}', [ShippingController::class, 'orderDetails'])->name('shipping.details');
Route::get('/shipping', [ShippingController::class, 'index'])->name('shipping'); // หน้าแสดงรายการจัดส่ง
Route::post('/shipping/print', [ShippingController::class, 'printOrders'])->name('shipping.print'); // ปริ้นใบสั่งซื้อ

// route::get('/testja', [HomeController::class, 'testtest'])->name('test');


Route::post('/hold-order', [CartController::class, 'hold']);
Route::post('/resume-order', [CartController::class, 'resume']);


//supplier
Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
Route::get('/suppliers/{id}', [SupplierController::class, 'show'])->name('suppliers.show');

Route::prefix('admin')->group(function () {

    Route::get('/orders/today', [AdminController::class, 'ordersToday'])->name('admin.today');

    Route::get('/orders/month', [AdminController::class, 'ordersMonth'])->name('admin.month');

    Route::get('/orders/pending', [AdminController::class, 'ordersPending'])->name('admin.pending');

    // Route::get('/orders/completed', [AdminController::class, 'ordersCompleted'])->name('admin.completed');
    Route::get('/admin/orders/completed', [AdminController::class, 'ordersCompleted'])->name('admin.completed');

    Route::get('/admin/orders/proof', [AdminController::class, 'proofList']) ->name('admin.proof');

    Route::get('/orders/proof/{id}', [AdminController::class, 'showProof'])
    ->name('admin.proof.show');
});


Route::post('/units', [UnitController::class, 'store']) ->name('units.store');

//setting store
Route::get('/store-settings', [StoreSettingController::class, 'edit'])
    ->name('store-settings.edit');

Route::post('/store-settings', [StoreSettingController::class, 'update'])
    ->name('store-settings.update');
