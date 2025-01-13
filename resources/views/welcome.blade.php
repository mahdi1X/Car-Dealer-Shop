<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">

</head>

<body>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="background-image: url('{{ asset('storage/common-images/germaniya-flag-germany-flag.webp') }}');" >
        
    {{-- style="background-image: C:\Users\HP i5\OneDrive\Desktop\Project\ProjectWeb\storage\app\public\commonimages\germaniya-flag-germany-flag.webp"
    class="navbar navbar-expand-lg navbar-light bg-light" --}}
    {{-- > --}}

        <a class="navbar-brand" href="#">Car Shop</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                @foreach ($brands as $brand)
                    <li class="nav-item active">
                        {{-- <a class="nav-link" href="{{route('brands.show')}}">{{ $brand->name}}</a> --}}
                        <a class="nav-link" href="{{route('brands.show', ['brand' => $brand->id]) }}">{{ $brand->name}}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </nav>

    @yield('content')

</body>

</html>
