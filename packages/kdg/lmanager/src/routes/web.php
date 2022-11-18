<?php
    Route::group(['namespace' => 'KDG\LManager\Http\Controllers', 'middleware' => ['web']], function(){
        Route::get('admin/languages/list', 'LanguageController@index')->name('system_languages');
        Route::get('admin/languages/getList', [ 'as'   => 'languages.dataTable',
             'uses' => 'LanguageController@getDatatable']);
         
        Route::get('admin/languages/add', 'LanguageController@create');
        Route::post('admin/languages/add', 'LanguageController@store');
        Route::get('admin/languages/edit/{slug}', 'LanguageController@edit');
        Route::patch('admin/languages/edit/{slug}', 'LanguageController@update');
        Route::delete('admin/languages/delete/{slug}', 'LanguageController@delete');
        
        Route::get('admin/languages/token_list', 'LanguageController@token_list')->name('language_tokens');
        Route::get('admin/languages/add_token', 'LanguageController@add_token');
        Route::post('admin/languages/add_token', 'LanguageController@save_token');
        Route::get('admin/languages/getTokenList', [ 'as'   => 'languages.token_dataTable',
             'uses' => 'LanguageController@getTokenDatatable']);
        Route::get('admin/languages/edit-token/{id}', 'LanguageController@edit_token');
        Route::patch('admin/languages/edit-token/{id}', 'LanguageController@update_token');
        Route::delete('admin/languages/delete-token/{id}', 'LanguageController@delete_token');

        Route::get('admin/languages/make-default/{slug}', 'LanguageController@changeDefaultLanguage')->name('makeDefaultLanguage');
        Route::get('admin/languages/update-strings/{slug}', 'LanguageController@updateLanguageStrings');
        Route::patch('admin/languages/update-strings/{slug}', 'LanguageController@saveLanguageStrings');

        /* Page wise list for which token will be added */
        Route::get('admin/languages/page_list', 'LanguageController@page_list')->name('language_pages');
        Route::get('admin/languages/add_page', 'LanguageController@add_page');
        Route::post('admin/languages/add_page', 'LanguageController@save_page');
        Route::get('admin/languages/getPageList', [ 'as'   => 'languages.page_dataTable',
             'uses' => 'LanguageController@getPageDatatable']);
        Route::get('admin/languages/edit-page/{id}', 'LanguageController@edit_page');
        Route::patch('admin/languages/edit-page/{id}', 'LanguageController@update_page');
        Route::delete('admin/languages/delete-page/{id}', 'LanguageController@delete_page');
    });