<html>

<head>
    <title>Chat App</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css"
          rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" type="text/css" rel="stylesheet">
    <link href="/style.css" type="text/css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>

<body>
<div id="app" class="container">
    <chat-layout :user = "{{ auth()->user() }}"></chat-layout>
</div>

</body>

</html>
