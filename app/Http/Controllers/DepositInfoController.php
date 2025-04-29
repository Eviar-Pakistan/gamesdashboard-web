<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DepositInfo;
class DepositInfoController extends Controller
{
    //
	public function index()
	{
		return response()->json([
			'status' => 'success',
			'data' => DepositInfo::all()
		], 200);
	}
}
