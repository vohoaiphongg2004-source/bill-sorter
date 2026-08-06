<!doctype html>
<html>
<head>

    <title>Bill Sorter</title>

</head>

<body>

<h2>Upload Bill TikTok</h2>

<form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">

    @csrf

    <input type="file" name="pdf">

    <button>Upload</button>

</form>

</body>
</html>