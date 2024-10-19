<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\models\User;
use App\models\Skripsi;

class ListController extends Controller
{
   public function index()
    {
       $admins = Admin::all();
        $users = User::all();
        $skripsis = Skripsi::all();

        return view('Welcome', compact('admins', 'users', 'skripsis'));
    }
    }
 


