<!doctype html>
<html lang="vi">

<head>

    <meta charset="UTF-8">

    <title>Kết quả Shopee</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background: #f5f5f5;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        h2 {
            margin-top: 0;
        }

        textarea {
            width: 100%;
            height: 100px;
            margin-bottom: 10px;
            font-size: 16px;
            padding: 10px;
            resize: vertical;
        }

        button {
            padding: 9px 18px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            background: #1677ff;
            color: white;
        }

        button:hover {
            background: #0958d9;
        }

        .result {
            margin-top: 20px;
        }

        .success {
            color: green;
            font-weight: bold;
        }

    </style>

</head>

<body>

<div class="container">

    <h2>Kết quả sắp xếp Bill Shopee</h2>

    <p class="success">
        Đã sắp xếp thành công!
    </p>

    <h3>Thứ tự trang cần in</h3>

    <textarea
        id="pagesToPrint"
        readonly
    >{{ $pagesToPrint }}</textarea>

    <button onclick="copyPages()">
        Sao chép
    </button>

    <div class="result">

        <p>
            Tổng số bill:
            <strong>{{ count(explode(',', $pagesToPrint)) }}</strong>
        </p>

    </div>

</div>


<script>

function copyPages() {

    const text = document.getElementById("pagesToPrint").value;

    navigator.clipboard.writeText(text)
        .then(function () {

            alert("Đã sao chép thứ tự trang!");

        })
        .catch(function () {

            alert("Không thể sao chép!");

        });

}

</script>

</body>

</html>