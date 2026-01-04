<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Http\Controllers\Controller;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $banners = Banner::all();
    return view('admin.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view('admin.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'judul' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        'gambar' => 'required|image|max:2048',
        'status' => 'required|boolean',
    ]);

    // PATH FOLDER
    $folder = storage_path('app/public/banners');

    // BUAT FOLDER JIKA BELUM ADA
    if (!File::exists($folder)) {
        File::makeDirectory($folder, 0755, true);
    }

    $image = $request->file('gambar');
    $filename = time() . '.' . $image->getClientOriginalExtension();
    $path = $folder . '/' . $filename;

    // RESIZE & SAVE
    $manager = new ImageManager(new Driver());
    $manager
        ->read($image)
        ->resize(1200, 400)
        ->save($path);

    // SIMPAN KE DATABASE
    Banner::create([
        'judul' => $request->judul,
        'deskripsi' => $request->deskripsi,
        'gambar' => 'banners/' . $filename,
        'status' => $request->status,
    ]);

    return redirect()
    ->route('admin.banners.index')
    ->with('success', 'Banner berhasil ditambahkan.');
}

    
    //     
    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
{
    $request->validate([
        'judul' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        'gambar' => 'nullable|image|max:2048',
        'status' => 'required|boolean',
    ]);

    if ($request->hasFile('gambar')) {

        $image = $request->file('gambar');
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $path = storage_path('app/public/banners/' . $filename);

        // INIT IMAGE MANAGER (Intervention v3)
        $manager = new ImageManager(new Driver());

        // RESIZE AGAR SERAGAM
        $manager
            ->read($image)
            ->resize(1200, 400)
            ->save($path);

        $banner->gambar = 'banners/' . $filename;
    }

    $banner->judul = $request->judul;
    $banner->deskripsi = $request->deskripsi;
    $banner->status = $request->status;
    $banner->save();

    return redirect()
        ->route('admin.banners.index')
        ->with('success', 'Banner berhasil diperbarui!');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
         $banner->delete();
        return redirect()->route('admin.banners.index')->with('success','Banner berhasil dihapus!');
    }
}
