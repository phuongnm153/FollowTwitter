<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #333;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #333;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    {{!empty($status) ? 'Lưu thành công' : ''}}
    @if(Session::has('user.id'))
    <a href="/users/followingList" target="_blank">Xem danh sách follow</a>
    @endif
    @if(!empty($followList))
    <table border="1" cellpadding="5" cellspacing="5">
        <thead>
        <th>ID</th>
        <th>Name</th>
        </thead>
        @foreach($followList as $u)
        <tr>
            <td>{{$u['id']}}</td>
            <td>{{$u['name']}}</td>
        </tr>
        @endforeach
    </table>
    @endif
</body>
</html>