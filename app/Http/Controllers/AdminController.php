<?php

namespace App\Http\Controllers;

use App\{Story, Category, User, Profile};
use Illuminate\Http\Request;
use App\Http\Requests\StoryRequest;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /*
    * Tampilkan menu dashboard
    */
    public function index()
    {
        // mengambil data stories dengan mengecek sesuai role akun
        $story = (auth()->id() == 1) ? Story::get() : Story::where('user_id', auth()->id())->get();
        // tampilkan menu
        return view('admin.dashboard', [
            'no' => 1, // nomor
            'stories' => Story::orderBy('views', 'desc')->limit(10)->get(['title', 'views', 'created_at']), // semua data penulis teratas
            'text' => $story->count(), // jumlah tulisan
            'views' => $story->sum('views'), // jumlah yang dibaca
            'likes' => $story->sum('likes') // jumlaj like
        ]);
    }

    /*
    * Tampilkan menu untuk menambahkan tulisan baru
    */
    public function new()
    {
        // ambil semua data kategori
    	$categories = Category::get();
        // tampilkan menu
    	return view('admin.new', compact('categories'));
    }

    /*
    * Mengambil data post untuk menyimpan tulisan baru
    */
    public function save(Story $story, StoryRequest $request)
    {
        // ambil semua data request
    	$data = $request->all();

        // ambil informasi file gambar
        $picture = $request->file('picture');
        // simpan gambar kedalam storage
        $picture_url = $picture->storeAs('images/stories', time().'.'.$picture->extension());

        // memasukkan seluruh data yang diperlukan untuk dimasukkan ke database
    	$data['slug'] = Str::slug(request('title'));
    	$data['user_id'] = auth()->id();
    	$data['category_id'] = $request->category;
    	$data['views'] = 0;
    	$data['likes'] = 0;
        $data['picture'] = $picture_url;
    	
        // simpan semua data
    	$story->create($data);

        // tambahkan pesan untuk ditampilkan
        session()->flash('success', 'Teks berhasil diposting!');

        // mengalihkan halaman ke menu semua teks
    	return redirect()->to(route('admin.all'));
    }

    /*
    * Tampilkan semua teks penulis
    */
    public function all(Story $stories)
    {
        // cek jika penulis adalah admin maka tampilkan semua tulisan
        if(auth()->id() == 1)
            $stories = $stories->with('category')->paginate(10);
        else
            // jika bukan admin, tampilkan tulisan berdasrakan is penulisnya
            $stories = $stories->with('category')->where('user_id', auth()->id())->paginate(10);

        // tampilkan data
    	return view('admin.all', [
    		'stories' => $stories,
    		'no' => 1
    	]);
    }

    /*
    * Tampilkan menu untuk mengedit tulisan
    */
    public function edit(Story $story)
    {
        // cek jika penulis mengakses data miliknya sendiri
        $this->authorize('edit', $story);

        // tampikan menu
        return view('admin.edit', [
            'story' => $story,
            'categories' => Category::get()
        ]);
    }

    /*
    * Simpan semua data yang akan di update
    */
    public function update(Story $story, StoryRequest $request)
    {
        // cek jika penulis mengakses data miliknya sendiri
        $this->authorize('edit', $story);
        // mengambil semua data request
        $data = $request->all();

        // cek apabila akan mengupdate gambar
        if($request->file('picture')){
            // simpan gambar ke storage
            $picture_url = $request->file('picture')->storeAs('images/stories', time().'.'.$request->file('picture')->extension());
            // hapus gambar sebelumnya
            \Storage::delete($story->picture); 
        }
        else{
            // berikan path gambar sebelumnya jika tidak mengupdate gambar
            $picture_url = $story->picture;
        }

        // menambahkan data yang perlu di update
        $data['picture'] = $picture_url;
        $data['category_id'] = $request->category;

        // simpan semua data
        $story->update($data);

        // tambahkan pesan untuk ditampilkan
        session()->flash('success', 'Teks berhasil diperbaharui');
        // alihkan ke halaman untuk melihat semua tulisan
        return redirect()->to(route('admin.all'));
    }

    /*
    * hapus data tulisan berdasarkan id
    */
    public function delete(Story $story)
    {
        // cek jika penulis mengakses data miliknya sendiri
        $this->authorize('edit', $story);

        // hapus gambarnya
        \Storage::delete($story->picture);
        // hapus semua data tulisan
        $story->where('id', request('id'))->delete();

        // tamhahkan pesan untuk ditampilkan
        session()->flash('success', 'Teks berhasil dihapus!');
        // alihkan ke halaman untuk melihat semua tulisan
        return redirect()->to(route('admin.all'));
    }

    public function profile()
    {
        $user = User::find(auth()->id());

        return view('admin.profile', compact('user'));
    }

    public function save_profile()
    {
        if(request('type') == 'general'){
            User::where('id', auth()->id())->update(['name' => request('name')]);
            return Profile::where('id', request('id'))->update([
                'gender' => request('gender'),
                'birth_date' => request('birth_date')
            ]);
        }

        if(request('type') == 'sosmed'){
            return Profile::where('id', request('id'))->update([
                'facebook_link' => request('facebook_link'),
                'instagram_link' => request('instagram_link'),
                'twitter_link' => request('twitter_link'),
            ]);
        }

        if(request('type') == 'bio'){
            return Profile::where('id', request('id'))->update([
                'status_bio' => request('bio')
            ]);
        }
    }

    public function settings()
    {
        return view('admin.settings');
    }
}
