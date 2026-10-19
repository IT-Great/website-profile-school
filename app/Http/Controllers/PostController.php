<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\News_page_setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class PostController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $posts = Post::query()

            ->when(
                $request->filled('search'),
                function ($query) use ($request) {

                    $query->where(
                        'title',
                        'like',
                        '%' . $request->search . '%'
                    );

                }
            )

            ->when(
                $request->filled('category'),
                function ($query) use ($request) {

                    if ($request->category !== 'all') {

                        $query->where(
                            'category',
                            $request->category
                        );

                    }

                }
            )

            ->when(
                $request->filled('status'),
                function ($query) use ($request) {

                    if ($request->status === 'active') {

                        $query->where(
                            'is_active',
                            true
                        );

                    }

                    if ($request->status === 'inactive') {

                        $query->where(
                            'is_active',
                            false
                        );

                    }

                }
            )

            ->latest('published_at')

            ->paginate(10)

            ->withQueryString();


        return inertia(
            'Public/Admin/News/News',
            [
                'posts' => $posts,

                'filters' => [
                    'search' =>
                        $request->search,

                    'category' =>
                        $request->category ?? 'all',

                    'status' =>
                        $request->status ?? 'all',
                ]
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return inertia(
            'Public/Admin/News/Create'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([

            'category' =>
                'required|in:news,event,activity,achievement',

            'title' =>
                'required|string|max:255',

            'excerpt' =>
                'nullable|string|max:1000',

            'content' =>
                'nullable|string',

            'thumbnail' =>
                'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',

            'published_at' =>
                'nullable|date',

            'is_featured' =>
                'nullable|boolean',

            'is_active' =>
                'nullable|boolean',
        ]);


        /*
        |--------------------------------------------------------------------------
        | SLUG
        |--------------------------------------------------------------------------
        */

        $slug =
            Str::slug(
                $request->title
            );

        $originalSlug =
            $slug;

        $counter = 1;


        while (
            Post::where(
                'slug',
                $slug
            )->exists()
        ) {

            $slug =
                $originalSlug
                . '-'
                . $counter++;

        }


        /*
        |--------------------------------------------------------------------------
        | THUMBNAIL
        |--------------------------------------------------------------------------
        */

        $thumbnail = null;


        if (
            $request->hasFile(
                'thumbnail'
            )
        ) {

            $file =
                $request->file(
                    'thumbnail'
                );


            $extension =
                $file->getClientOriginalExtension();


            $fileName =
                $slug
                . '-'
                . time()
                . '.'
                . $extension;


            $thumbnail =
                $file->storeAs(
                    'posts',
                    $fileName,
                    'public'
                );

        }


        /*
        |--------------------------------------------------------------------------
        | CREATE
        |--------------------------------------------------------------------------
        */

        Post::create([

            'category' =>
                $validated['category'],

            'title' =>
                $validated['title'],

            'slug' =>
                $slug,

            'excerpt' =>
                $validated['excerpt'] ?? null,

            'content' =>
                $validated['content'] ?? null,

            'thumbnail' =>
                $thumbnail,

            'published_at' =>
                $validated['published_at'] ?? now(),

            'is_featured' =>
                $request->boolean(
                    'is_featured'
                ),

            'is_active' =>
                $request->boolean(
                    'is_active'
                ),

            'created_by' =>
                auth()->id(),

        ]);


        return redirect()
            ->route(
                'admin.posts.index'
            )
            ->with(
                'success',
                'Post berhasil ditambahkan.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(Post $post)
    {
        return inertia(
            'Public/Admin/News/Edit',
            [
                'post' => $post,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Post $post
    ) {

        $validated =
            $request->validate([

                'category' =>
                    'required|in:news,event,activity,achievement',

                'title' =>
                    'required|string|max:255',

                'excerpt' =>
                    'nullable|string|max:1000',

                'content' =>
                    'nullable|string',

                'thumbnail' =>
                    'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',

                'published_at' =>
                    'nullable|date',

                'is_featured' =>
                    'nullable|boolean',

                'is_active' =>
                    'nullable|boolean',

            ]);


        /*
        |--------------------------------------------------------------------------
        | CHANGE SLUG
        |--------------------------------------------------------------------------
        */

        if (
            $post->title !==
            $request->title
        ) {

            $slug =
                Str::slug(
                    $request->title
                );

            $originalSlug =
                $slug;

            $counter = 1;


            while (
                Post::where(
                    'slug',
                    $slug
                )
                ->where(
                    'id',
                    '!=',
                    $post->id
                )
                ->exists()
            ) {

                $slug =
                    $originalSlug
                    . '-'
                    . $counter++;

            }


            $post->slug =
                $slug;

        }


        /*
        |--------------------------------------------------------------------------
        | IMAGE
        |--------------------------------------------------------------------------
        */

        if (
            $request->hasFile(
                'thumbnail'
            )
        ) {

            if (
                $post->thumbnail &&
                Storage::disk('public')
                    ->exists(
                        $post->thumbnail
                    )
            ) {

                Storage::disk('public')
                    ->delete(
                        $post->thumbnail
                    );

            }


            $file =
                $request->file(
                    'thumbnail'
                );


            $extension =
                $file->getClientOriginalExtension();


            $fileName =
                $post->slug
                . '-'
                . time()
                . '.'
                . $extension;


            $post->thumbnail =
                $file->storeAs(
                    'posts',
                    $fileName,
                    'public'
                );

        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE
        |--------------------------------------------------------------------------
        */

        $post->category =
            $validated['category'];

        $post->title =
            $validated['title'];

        $post->excerpt =
            $validated['excerpt'] ?? null;

        $post->content =
            $validated['content'] ?? null;

        $post->published_at =
            $validated['published_at'] ?? null;

        $post->is_featured =
            $request->boolean(
                'is_featured'
            );

        $post->is_active =
            $request->boolean(
                'is_active'
            );


        $post->save();


        return redirect()
            ->route(
                'admin.posts.index'
            )
            ->with(
                'success',
                'Post berhasil diperbarui.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy(Post $post)
    {
        if (
            $post->thumbnail &&
            Storage::disk('public')
                ->exists(
                    $post->thumbnail
                )
        ) {

            Storage::disk('public')
                ->delete(
                    $post->thumbnail
                );

        }


        $post->delete();


        return back()->with(
            'success',
            'Post berhasil dihapus.'
        );
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);

        $file = $request->file('image');

        $extension = strtolower(
            $file->getClientOriginalExtension()
        );

        $fileName =
            'article-' .
            now()->format('YmdHis') .
            '-' .
            Str::random(8) .
            '.' .
            $extension;

        $path = $file->storeAs(
            'posts/content',
            $fileName,
            'public'
        );

        return response()->json([
            'success' => true,
            'url' => asset(
                'storage/' . $path
            ),
        ]);
    }

    public function show($slug)
    {
        $article = Post::where('slug', $slug)
        ->where('is_active', 1)
        ->firstOrFail();

        return Inertia::render('Public/Admin/News/Views', [
            'article' => $article,
        ]);
    }

    public function editHero()
    {
        $setting = News_page_setting::first();

        if (!$setting) {
            $setting = News_page_setting::create([
                'title' => 'News',
                'description' => 'Great Crystal School and Course Center provides a complete academic journey through internationally and nationally recognized programs across Preschool, Primary, and Secondary.',
                'primary_button_text' => 'Get to Know',
                'primary_button_url' => '/about',
                'secondary_button_text' => 'Contact',
                'secondary_button_url' => '/contact',
                'is_active' => true,
            ]);
        }

        return Inertia::render(
            'Public/Admin/News/Header',
            [
                'setting' => $setting,
            ]
        );
    }

    public function updateHero(Request $request)
    {
        $setting = News_page_setting::first();

        if (!$setting) {
            $setting = new News_page_setting();
        }

        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'background_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'primary_button_text' => [
                'nullable',
                'string',
                'max:100',
            ],

            'primary_button_url' => [
                'nullable',
                'string',
                'max:500',
            ],

            'secondary_button_text' => [
                'nullable',
                'string',
                'max:100',
            ],

            'secondary_button_url' => [
                'nullable',
                'string',
                'max:500',
            ],

            'is_active' => [
                'boolean',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Background Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('background_image')) {

            if (
                $setting->background_image &&
                Storage::disk('public')->exists(
                    $setting->background_image
                )
            ) {
                Storage::disk('public')->delete(
                    $setting->background_image
                );
            }

            $file = $request->file('background_image');

            $extension = strtolower(
                $file->getClientOriginalExtension()
            );

            $fileName =
                'news-header-' .
                now()->format('YmdHis') .
                '-' .
                Str::random(8) .
                '.' .
                $extension;

            $path = $file->storeAs(
                'news',
                $fileName,
                'public'
            );

            $validated['background_image'] = $path;
        }

        $setting->fill($validated);

        $setting->is_active =
            $request->boolean('is_active');

        $setting->save();

        return redirect()
            ->route('admin.edit.post.header')
            ->with(
                'success',
                'News page header updated successfully.'
            );
    }
}