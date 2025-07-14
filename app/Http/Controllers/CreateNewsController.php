<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\News;
use Illuminate\Support\Facades\Storage;

class CreateNewsController extends Controller
{
    public function createNewsView()
    {
        //Check if user is admin
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Unauthorized access.');
        }

        // If so, grant access
        $news = News::latest()->get();
        return view('admin.newsAdminView', compact('news'));
    }

    //Storing new post
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'images.*' => '|image|mimes:jpg,jpeg,png,gif,webp|max:10048',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('news_images', 'public');
            }
        }

        News::create([
            'title' => $request->title,
            'content' => $request->content,
            'images' => $imagePaths,
        ]);

        return redirect()->back()->with('success', 'Novost dodana!');
    }

    //Update existing post
    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);
        $news->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        $newImagePaths = [];

        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $image) {
                $path = $image->store('news_images', 'public');
                $newImagePaths[] = $path;
            }

            $existing = $news->images ?? [];
            $news->images = array_merge($existing, $newImagePaths);
            $news->save();
        }

        return response()->json([
            'message' => 'Updated successfully.',
            'newImages' => $newImagePaths,
        ]);
    }

    // Delete existing post
    public function destroy($id)
    {
        $news = News::findOrFail($id);

        // Optional: Delete images from storage
        if ($news->images) {
            foreach ($news->images as $img) {
                Storage::disk('public')->delete($img);
            }
        }

        $news->delete();

        return response()->json(['message' => 'Deleted successfully.']);
    }

    //Delete images individualy
    public function deleteImage(Request $request, $id)
    {
        $request->validate([
            'image_path' => 'required|string',
        ]);

        $news = News::findOrFail($id);
        $images = $news->images ?? [];

        if (($key = array_search($request->image_path, $images)) !== false) {
            // Remove from array
            unset($images[$key]);

            // Delete from storage
            Storage::disk('public')->delete($request->image_path);

            // Reindex and save
            $news->images = array_values($images);
            $news->save();

            return response()->json(['message' => 'Slika obrisana.']);
        }

        return response()->json(['message' => 'Slika nije pronađena.'], 404);
    }
}
