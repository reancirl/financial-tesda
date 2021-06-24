<?php

Auth::routes();

Route::redirect('/','/login');

Route::group(['middleware' => ['auth']],function() { 

    Route::get('/dashboard','DashboardController@index')->name('dashboard.index');
    Route::get('/dashboard/search','DashboardController@search')->name('dashboard.search');

    Route::resource('cart','CartController');
    Route::resource('request','RequisitionController');   

    Route::group(['middleware' => ['role:admin|finance_officer|supply_officer']],function() { 
        Route::resource('supply','SupplyController');
        Route::resource('suppliers','SupplierController');
        Route::resource('bidding','BiddingController');
        Route::resource('qualification','QualificationController');
        Route::get('/award','PurchaseRequestController@award_index')->name('purchase-request.award_index');
        Route::get('/award-edit/{id}','PurchaseRequestController@award_edit')->name('purchase-request.award_edit');
        Route::patch('/award-edit/{id}','PurchaseRequestController@award_update')->name('purchase-request.award_update');
        Route::post('/purchase-request/award','PurchaseRequestController@award')->name('purchase-request.award');
        Route::resource('purchase-request','PurchaseRequestController');
        Route::resource('purchase-order','PurchaseOrderController');

        Route::post('/store-bulk','SupplyController@storeBulk')->name('storeBulk');
        Route::get('/add-bidders/{id}','BiddingController@addBidder')->name('addBidders');
        Route::get('reports/index','ReportsController@index')->name('reports.index');
        Route::get('reports/purchase-request','ReportsController@purchaseRequest')->name('reports.purchaseRequest');
        Route::get('reports/purchase-order','ReportsController@purchaseOrder')->name('reports.purchaseOrder');
        Route::get('/pmr','DashboardController@pmr')->name('dashboard.pmr');

        Route::group(['middleware' => ['role:admin']],function() { 
            Route::resource('users','UsersController');                
        });
    });    
});