<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['upload_form', 'download']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function upload_form()
    {
        return view('upload_form');
    }

    public function download($fileName)
    {
        if (!\Storage::disk('public')->exists("uploads\\$fileName")){
            return response()->json(['message' => 'Dosya bulunamadı'], 404);
        }
        //return response()->download(public_path("uploads\\$fileName"));
        return \Storage::disk('public')->download("uploads\\$fileName");
    }
}
