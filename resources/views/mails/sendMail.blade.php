<!DOCTYPE html>
<html>
<head>
    <title>{{ $mailSubject }}</title>
</head>
<body>
    <h1>{{ $mailSubject }}</h1>
    <p>{{ $mailMessage }}</p>
    <p>Email: {{ $mailEmail }}</p>
    <p>Password: {{ $mailPassword }}</p>
    @if($mailLink)
        <p>Click here to visit: <a href="{{ $mailLink }}">{{ $mailLink }}</a></p>
    @endif
</body>
</html>