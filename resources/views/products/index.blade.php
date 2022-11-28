<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>

    <div class="container">
        <h1 class="mt-5 text-center mb-3">List Products</h1>
        <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Add</a>

        @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

        <table class="table">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Name</th>
                <th scope="col">Price</th>
                <th scope="col">Slug</th>
                <th scope="col">Description</th>
                <th scope="col">Image</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
                @php
                    $no = 1
                @endphp
                @foreach ($products as $val)
              <tr>
                <td><?= $no++ ?></td>
                <td>{{ $val->name }}</td>
                <td>{{ $val->price }}</td>
                <td>{{ $val->slug }}</td>
                <td>{{ $val->description }}</td>
                <td>
                    <img src="{{ Storage::url('public/').$val->image }}" class="rounded" style="width: 150px">
                </td>
                <td>
                    <form onsubmit="return confirm('Are you sure?')" action="{{ route('products.destroy', $val->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                    <a href="{{ route('products.edit', $val->id) }}" class="btn btn-sm btn-primary">Edit</a>
                </td>
              </tr>
                @endforeach
            </tbody>
          </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>
