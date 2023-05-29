<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Consume REST API students || Trash</title>
</head>
<body>
    @if (Session::get('errors'))
    <p style="padding: 5px 10px; background: red; color:white; margin: 10px;">{{Session::get('errors')}}</p>
    @endif
    @if (Session::get('success'))
    <p style="padding: 5px 10px; background: green; color:white; margin: 10px;">{{Session::get('success')}}</p>
    @endif
    <a href="/">Kembali</a>
    <ol>
        @foreach ($studentsTrash as $student)
        <li>NIS : {{ $student['nis'] }}</li>
        <li>Nama : {{ $student['nama'] }}</li>
        <li>Rombel : {{ $student['rombel'] }}</li>
        <li>Rayon : {{ $student['rayon'] }}</li>
        <li>Dihapus tanggal : {{\Carbon\Carbon::parse($student['deleted_at'])->format('j f,y')}}</li>
        <li>
            <a href="{{route('restore', $student['id'])}}">Kembalikan Data</a>
            <a href="{{route('permanent', $student['id'])}}" style="background-color: orange; color:white">Hapus permanent</a>
        </li>
        @endforeach
</body>
</html>