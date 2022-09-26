<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title','OMS SpecDoc')</title>
</head>
<body>
@yield('content')

@stack('scripts')

<script>
  window.trans = @json(cache(app()->getLocale()), JSON_THROW_ON_ERROR)
</script>
</body>
</html>