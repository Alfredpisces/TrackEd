<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'TrackEd')</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <script src="{{ asset('js/auth.js') }}"></script>
</head>
<body class="min-h-screen bg-slate-100 flex items-center justify-center p-6">
  @yield('content')
  @yield('scripts')
</body>
</html>
