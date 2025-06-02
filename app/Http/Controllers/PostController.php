<?php

namespace App\Http\Controllers;
use App\Models\Post;
//use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class PostController extends Controller 
{
    public function create()
    {
        return view('product');
    }
    public function product_store(Request $request)
    {
       $field= $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        $filename= null;
        if(isset($request->image))
        {
             $filename = time() . '.' . $request->image->extension();

    $request->image->move(public_path('images'), $filename);
        }
        $post = new Post();
        $post->name = $request->name;
        $post->price = $request->price;
        $post->image =  $filename;
        $post->user_id = $request->user()->id; 
        
        $post->save();

        return redirect()->route('home')->with('success');
    }
public function product_edit($id)
{
    $post= Post::findOrFail($id);

   return view('edit', ['ourpost'=>$post]);
}

public function product_update(Request $request, $id)
{
    $post = Post::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    if ($request->hasFile('image')) {
        // Delete old image
        if ($post->image && file_exists(public_path('images/' . $post->image))) {
            unlink(public_path('images/' . $post->image));
        }

        $filename = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $filename);
        $post->image = $filename;
    }

    $post->name = $request->name;
    $post->price = $request->price;
    $post->save();

    return redirect()->route('home')->with('success', 'Product updated successfully!');
}
public function product_delete($id)
{
     $post = Post::findOrFail($id);
     $post->delete();
     return redirect()->route('home')->with('success', 'Product Deleted successfully!');
}
}
?>