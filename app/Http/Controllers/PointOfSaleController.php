<?php

namespace App\Http\Controllers;

use App\Models\POSData;
use Illuminate\Http\Request;

class PointOfSaleController extends Controller
{
    // Function to view All Scanners List
    public function list()
    {
        $pos = POSData::all();
        return view('pages.pos.view')->with('pos', $pos);
    }

    // Function to view Add Scanner
    public function viewAdd()
    {
        return view('pages.pos.add');
    }

    // Function to view Edit Scanner
    public function viewEdit($id)
    {
        return view('pages.pos.edit');
    }

    // Function to view Do Add Scanner
    public function doAdd(Request $request)
    {
        return view('pages.pos.add');
    }

    // Function to view Do Edit Scanner
    public function doEdit(Request $request, $id)
    {
        return view('pages.pos.edit');
    }

    // Function to view Delete Scanner
    public function doDelete($id)
    {
        return view('pages.pos.delete');
    }

    // Function to view Scanner Details
    public function details($id)
    {
        return view('pages.pos.details');
    }
}
