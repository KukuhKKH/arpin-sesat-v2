<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'pemilik', 'middleware' => 'role:pemilik', 'as' => 'owner.'], function() {

});
