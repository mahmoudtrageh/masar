<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Review;
use App\Models\Url;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('created_at', 'desc')->paginate(5);
        return view('index', ['categories' => $categories]);
    }

    public function urls(Category $category)
    {
        $urls = $category->urls()->paginate(5);
        return view('urls', compact('urls'));
    }

    public function urlDetails(Url $url)
    {
        $reviewExists = Review::where('category_id', $url->category_id)
        ->where('url_id', $url->id)
        ->where('user_id', Auth::id())
        ->exists();

        return view('url-details', compact('url', 'reviewExists'));
    }

    public function addCategory()
    {
        return view('add-category');
    }

    public function addUrl()
    {
        $categories = Category::select('id', 'title')->get();
        return view('add-url', ['categories' => $categories]);
    }

    public function storeCategory(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|unique:categories,title',
            'description' => 'nullable',
            'average_duration' => 'nullable',
        ]);

        $data['slug'] = Str::slug($request->name);
        $data['user_id'] = Auth::id();

        Category::create($data);

        return redirect()->route('home')->with('success', 'Category created successfully.');
    }
    public function storeUrl(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'average_duration' => 'nullable',
            'url' => 'required',
            'category_id' => 'required',
        ]);

        $data['user_id'] = Auth::id();

        Url::create($data);

        return redirect()->route('urls', $request->category_id)->with('success', 'Url created successfully.');
    }

    public function createReview(Request $request)
    {
        $data = $request->validate([
            'review' => 'required',
            'rate' => 'nullable',
            'category_duration' => 'nullable',
            'url_duration' => 'nullable',
            'category_id' => 'nullable',
            'url_id' => 'nullable',
            'order' => 'nullable',
        ]);

        $data['user_id'] = Auth::id();

        Review::create($data);

        return redirect()->route('url.details', $request->url_id)->with('success', 'Review created successfully.');
    }

    public function urlReviews(Url $url)
    {
        $reviews = $url->reviews()->paginate(10);
        return view('reviews', ['reviews' => $reviews]);
    }

    public function categoryReviews(Category $category)
    {
        $reviews = $category->reviews()->paginate(10);
        return view('reviews', ['reviews' => $reviews]);
    }

    public function store(Request $request, $type, $id)
    {
        $favouritable = null;

        if ($type === 'category') {
            $favouritable = Category::findOrFail($id);
        } elseif ($type === 'url') {
            $favouritable = Url::findOrFail($id);
        }

        // Add to favourites
        Auth::user()->favourites()->create([
            'favouritable_id' => $favouritable->id,
            'favouritable_type' => get_class($favouritable),
        ]);

        return redirect()->back()->with('success', 'Added to favourites!');
    }

    public function destroy(Request $request, $type, $id)
    {
        $favouritable = null;

        if ($type === 'category') {
            $favouritable = Category::findOrFail($id);
        } elseif ($type === 'url') {
            $favouritable = Url::findOrFail($id);
        }

        // Remove from favourites
        Auth::user()->favourites()->where([
            'favouritable_id' => $favouritable->id,
            'favouritable_type' => get_class($favouritable),
        ])->delete();

        return redirect()->back()->with('success', 'Removed from favourites!');
    }

    public function favourites()
    {
        $favourites = Auth::user()->favourites()->with('favouritable')->get();

        $results = collect();

        foreach ($favourites as $favourite) {
            if ($favourite->favouritable_type === Url::class) {
                $category = $favourite->favouritable->category;

                if ($category) {
                    $results->push($category);
                }
            }
        }

        $uniqueResults = $results->unique(function ($item) {
            return $item->id;
        });

        return view('profile.favourites', ['favourites' => $uniqueResults]);
    }

    public function urlFavourites(Category $category)
    {
        $favourites_ids = Auth::user()->favourites()
        ->where('favouritable_type', Url::class)
        ->pluck('favouritable_id')
        ->toArray();

        $favourites = Url::whereIn('id', $favourites_ids)->where('category_id', $category->id)->get();
        return view('profile.url-favourites', ['favourites' => $favourites]);
    }
}
