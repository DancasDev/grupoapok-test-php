<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\V1\NodeController AS NodeV1Controller;

/**
 * Versión 1: Sólo estoy tratando de satisfacer la necesidad, pero tal vez no con las mejores prácticas.
 */
Route::post('v1/nodes', [NodeV1Controller::class, 'store']);
Route::get('v1/nodes/root', [NodeV1Controller::class, 'showParents2']);
Route::get('v1/nodes/{id}/children', [NodeV1Controller::class, 'showChildren']);
Route::get('v1/nodes/{id}/parents', [NodeV1Controller::class, 'showParents']);
Route::delete('v1/nodes/{id}', [NodeV1Controller::class, 'destroy']);

