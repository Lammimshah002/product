<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
 public function product_store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $filename = null;

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $filename); 
    }

    $post = new Post();
    $post->name = $request->name;
    $post->price = $request->price;
    $post->image = $filename;
    $post->user_id = $request->user()->id; 

    $post->save();

    return response()->json([
        'message' => 'Product created successfully',
        'data' => $post
    ], 201);
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

    return response()->json([
        'message' => 'Product updated successfully',
        'data' => $post
    ]);
}

public function product_delete($id)
{
    $post = Post::find($id);


    if (!$post) {
        return response()->json([
            'message' => 'Product not found.'
        ], 404);
    }

   
    if ($post->image && file_exists(public_path('images/' . $post->image))) {
        unlink(public_path('images/' . $post->image));
    }
    $post->delete();

    return response()->json([
        'message' => 'Product deleted successfully'
    ]);
}



}
 