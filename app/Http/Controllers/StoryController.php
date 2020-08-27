<?php

namespace App\Http\Controllers;

use App\{Story, Category};
use Illuminate\Http\Request;
use App\Http\Requests\StoryRequest;
use Illuminate\Support\Str;

class StoryController extends Controller
{

    public function index(Story $story)
    {
    	$stories = $story->with('author')->latest()->paginate(6);

    	return view('stories.index', [
    		'stories' => $stories,
    		'categories' => Category::get()
    	]);
    }

    public function indexByCategory(Category $category)
    {
    	$stories = $category->story()->latest()->paginate(8);

    	return view('stories.index', [
    		'stories' => $stories,
    		'categories' => Category::get()
    	]);
    }

    public function indexByType(Story $story)
    {
        $stories = $story->where('type', request('type'))->latest()->paginate(8);

        return view('stories.index', [
            'stories' => $stories,
            'categories' => Category::get()
        ]);
    }

    public function show(Story $story)
    {
        Story::find($story->id)->increment('views');
        return view('stories.show', [
            'story' => $story,
            'categories' => Category::get(),
            'stories' => Story::where('category_id', $story->category_id)->limit(4)->orderBy('created_at', 'desc')->get()
        ]);
    }

    public function like()
    {
        Story::find(request('id'))->increment('likes');
        return 'ok';
    }

    public function search()
    {
        $query = request('qr');
        $stories = Story::where('title', 'like', "%$query%")->latest()->paginate(8);

        return view('stories.index', [
            'search' => $query,
            'stories' => $stories,
            'categories' => Category::get()
        ]);
    }
}
