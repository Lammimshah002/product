<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>
    <style type="text/tailwindcss">
      @layer utilities {
        .container {
          @apply px-10 mx-auto;
        }
      }
    </style>
    <title>Product Form</title>
  </head>
  <body>
    <div class="container">
      <div class="flex justify-between my-5">
        <h1 class="text-red-500 text-xl font-bold">Product Edit - {{ $ourpost->name}}</h1>
        <a href="/" class="bg-green-600 text-white rounded py-2 px-4">Back To Home</a>
      </div>

     <form method="POST" action="{{ route('update',$ourpost->id) }}" enctype="multipart/form-data">
        @csrf
  <div class="mb-4">
    <label for="name" class="block mb-1 font-medium text-gray-700">Product Name</label>
 <input type="text" id="name" name="name" placeholder="Product Name" value="{{$ourpost->name}}"
  class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-300" required>
  </div>

  <div class="mb-4">
    <label for="price" class="block mb-1 font-medium text-gray-700">Price</label>
    <input type="number" id="price" name="price" placeholder="Price" value="{{$ourpost->price}}"
      class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-300" required>
  </div>

  <div class="mb-4">
    <label for="image" class="block mb-1 font-medium text-gray-700">Select Image</label>
    <input type="file" name="image" id="image" value="{{$ourpost->image}}" class="w-full">
  </div>

  <button type="submit"
    class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition">Submit</button>
</form>
    </div>
  </body>
</html>
