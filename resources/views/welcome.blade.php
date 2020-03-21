<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>Welcome - PaulHack Beauty Contest</title>

        <!-- CSS -->
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
        <link rel="stylesheet" href="/assets/css/app.css">

    </head>
    <body>

        <div class="container">
            <div class="row">
                <div class='list-group gallery'>
                @foreach ($contestants as $contestants)
                    <div class='col-sm-4 col-xs-12 col-sm-6 col-md-3 col-lg-3'>
                        <a class="thumbnail fancybox" rel="ligthbox" href="{{ $contestants->image }}">
                            <img class="img-responsive" alt="" src="{{ $contestants->image }}">
                            <div class='text-right'>
                                <small class='text-muted'>{{ $contestants->name }}, {{ $contestants->age }}</small>
                            </div>
                        </a>
                        <div class="vote-link">
                            <a href="/vote/{{ $contestants->slug }}" class="btn btn-default">Vote {{ $contestants->name }}</a>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>

        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
        <script src="/assets/js/app.js"></script>

    </body>
</html>
