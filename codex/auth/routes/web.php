<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author Robin Radic
 * @copyright Copyright 2017 (c) Codex Project
 * @license http://codex-project.ninja/license The MIT License
 */




Route::get('{service}/login', ['as' => 'login', 'uses' => 'AuthController@redirect']);
Route::get('{service}/callback', ['as' => 'login.callback', 'uses' => 'AuthController@callback']);
Route::get('{service}/logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);

Route::get('protected', ['as' => 'protected', 'uses' => 'AuthController@getProtected']);
