<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author    Robin Radic
 * @copyright Copyright 2017 (c) Codex Project
 * @license   http://codex-project.ninja/license The MIT License
 */
Route::get('{project}', 'CodexPhpdocApiController@getProject')->name('project');
Route::get('{project}/{revision}', 'CodexPhpdocApiController@getManifest')->name('manifest');
Route::get('{project}/{revision}/{hash}', 'CodexPhpdocApiController@getFile')->name('file');
Route::get('{project}/{revision}/full', 'CodexPhpdocApiController@getFull')->name('full');
