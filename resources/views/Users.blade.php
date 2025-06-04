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
        .btn{
          @apply bg-green-600 text-white rounded py-2 px-4
        }
                .btn1{
          @apply bg-red-600 text-white rounded py-2 px-4
        }
      }
    </style>
    <title>Product List</title>
  </head>
  <body>
    <div class="container">
      <div class="flex justify-between my-5">
        <h1 class="text-red-500 text-xl font-bold">Home</h1>
        <a href="{{ route('product') }}" class="bg-green-600 text-white rounded py-2 px-4">Add new Product</a>
      </div>

      @if(session('success'))
        <h2 class="text-green-500 mb-4">{{ session('success') }}</h2>
      @endif

      <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th class="px-6 py-3">ID</th>
              <th class="px-6 py-3">Product Name</th>
              <th class="px-6 py-3">Price</th>
              <th class="px-6 py-3">Image</th>
              <th class="px-6 py-3">User Name</th>
              <th class="px-6 py-3">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($posts as $post)
              <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                <td class="px-6 py-4">{{ $post->id }}</td>
                <td class="px-6 py-4">{{ $post->name }}</td>
                <td class="px-6 py-4">{{ $post->price }}</td>
                <td class="px-6 py-4">
                  <img src="images/{{$post->image}}" width="80px" alt="{{ $post->name }}" class="w-16 h-16 object-cover rounded">
                </td>
                 <td class="px-6 py-4">{{ $post->user->name}}</td>
                <td class="px-6 py-4 flex space-x-2">
                  <a href="{{route("edit",$post)}}" class="btn">Edit</a>
                  <a href="{{route("delete",$post)}}" class="btn1">Delete</a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
         {{$posts->links()}}
      </div>
    </div>
  </body>
</html>
