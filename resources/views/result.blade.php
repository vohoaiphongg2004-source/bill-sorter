<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Kết quả</title>

<style>

body{
    font-family:Arial;
    padding:20px;
}

table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    border:1px solid #ddd;
    padding:8px;
}

th{
    background:#f5f5f5;
}

textarea{
    width:100%;
    height:60px;
    resize:none;
}

button{
    padding:6px 12px;
    cursor:pointer;
}

</style>

</head>
<body>

<h2>Danh sách trang cần in</h2>

<table>

<tr>
    <th>Sản phẩm</th>
    <th>Số bill</th>
    <th>Trang</th>
    <th></th>
</tr>

@foreach($groups as $product=>$item)

<tr>

    <td>{{ $product }}</td>

    <td>{{ $item['count'] }}</td>

    <td width="55%">
        <textarea id="page{{ $loop->index }}" readonly>{{ $item['pages'] }}</textarea>
    </td>

    <td width="120">

        <button onclick="copyPage('page{{ $loop->index }}')">
            Sao chép
        </button>

    </td>

</tr>

@endforeach

</table>

<script>

function copyPage(id){

    let text=document.getElementById(id);

    text.select();
    text.setSelectionRange(0,99999);

    navigator.clipboard.writeText(text.value);

    alert("Đã sao chép!");

}

</script>

</body>
</html>