<!doctype html>
<html lang="vi">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Kết quả - Bill Sorter</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {

            margin: 0;

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            background:
                linear-gradient(
                    135deg,
                    #f5f7ff,
                    #eef2ff
                );

            color: #1f2937;

            min-height: 100vh;
        }

        .container {

            width: 92%;

            max-width: 1100px;

            margin: 40px auto;
        }

        .header {

            text-align: center;

            margin-bottom: 30px;
        }

        .header h1 {

            margin: 0;

            font-size: 32px;
        }

        .header p {

            margin-top: 8px;

            color: #6b7280;
        }

        .card {

            background: white;

            border-radius: 16px;

            padding: 25px;

            margin-bottom: 25px;

            box-shadow:
                0 8px 30px rgba(0,0,0,.07);
        }

        .title {

            display: flex;

            align-items: center;

            gap: 12px;

            margin-bottom: 18px;
        }

        .icon {

            width: 44px;
            height: 44px;

            display: flex;

            align-items: center;
            justify-content: center;

            background: #eef2ff;

            border-radius: 10px;

            font-size: 22px;
        }

        .title h2 {

            margin: 0;

            font-size: 20px;
        }

        .title p {

            margin: 4px 0 0;

            color: #6b7280;

            font-size: 13px;
        }

        .page-row {

            display: flex;

            gap: 10px;
        }

        #pageList {

            flex: 1;

            min-width: 0;

            padding: 13px 15px;

            border: 1px solid #d1d5db;

            border-radius: 9px;

            background: #f9fafb;

            font-size: 16px;

            outline: none;
        }

        button,
        .btn {

            border: none;

            border-radius: 8px;

            padding: 11px 16px;

            font-size: 14px;

            font-weight: 600;

            cursor: pointer;

            text-decoration: none;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            transition: .2s;
        }

        button:hover,
        .btn:hover {

            transform: translateY(-1px);
        }

        .copy {

            background: #4f46e5;

            color: white;
        }

        .download {

            background: #16a34a;

            color: white;
        }

        .download:hover {

            background: #15803d;
        }

        .copied {

            display: block;

            margin-top: 10px;

            color: #16a34a;

            font-size: 13px;
        }

        .products-header {

            display: flex;

            align-items: center;

            justify-content: space-between;

            margin-bottom: 20px;
        }

        .products-header h2 {

            margin: 0;
        }

        .badge {

            background: #eef2ff;

            color: #4f46e5;

            padding: 6px 12px;

            border-radius: 20px;

            font-size: 13px;

            font-weight: bold;
        }

        .table-wrapper {

            overflow-x: auto;
        }

        table {

            width: 100%;

            border-collapse: collapse;

            min-width: 700px;
        }

        th {

            background: #f8fafc;

            color: #475569;

            padding: 13px;

            text-align: left;

            font-size: 13px;

            border-bottom: 2px solid #e5e7eb;
        }

        td {

            padding: 14px 13px;

            border-bottom: 1px solid #edf0f3;

            vertical-align: middle;
        }

        tbody tr:hover {

            background: #fafbff;
        }

        .product-name {

            font-weight: 600;

            line-height: 1.5;

            max-width: 500px;
        }

        .count {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            min-width: 35px;

            height: 30px;

            padding: 0 10px;

            background: #f3f4f6;

            border-radius: 7px;

            font-weight: bold;
        }

        textarea {

            width: 100%;

            height: 45px;

            resize: none;

            border: 1px solid #e5e7eb;

            border-radius: 7px;

            background: #f9fafb;

            padding: 11px;

            font-family: Consolas, monospace;

            font-size: 13px;

            outline: none;
        }

        .copy-small {

            background: #eef2ff;

            color: #4f46e5;
        }

        .multi-box {

            background: #fff7ed;

            border: 1px solid #fed7aa;

            color: #9a3412;
        }

        .empty {

            text-align: center;

            padding: 40px;

            color: #9ca3af;
        }

        .footer {

            text-align: center;

            margin-top: 25px;

            color: #9ca3af;

            font-size: 13px;
        }

        @media (max-width: 700px) {

            .container {

                width: 94%;

                margin: 20px auto;
            }

            .card {

                padding: 18px;
            }

            .page-row {

                flex-direction: column;
            }

            .page-row button,
            .page-row .btn {

                width: 100%;
            }

            .products-header {

                align-items: flex-start;

                gap: 10px;
            }

        }

    </style>

</head>


<body>

<div class="container">


    <div class="header">

        <h1>📦 Bill Sorter</h1>

        <p>
            Bill Shopee đã được sắp xếp
        </p>

    </div>


    <!-- THỨ TỰ TRANG -->

    <div class="card">

        <div class="title">

            <div class="icon">
                📄
            </div>

            <div>

                <h2>
                    Thứ tự trang cần in
                </h2>

                <p>
                    Thứ tự PDF sau khi sắp xếp
                </p>

            </div>

        </div>


        <div class="page-row">

            <input
                type="text"
                id="pageList"
                value="{{ $pageList }}"
                readonly
            >


            <button
                class="copy"
                onclick="copyPages()"
            >
                📋 Sao chép
            </button>


            <a
                class="btn download"
                href="{{ route('shopee.download') }}"
            >
                ⬇️ Tải PDF
            </a>

        </div>


        <span
            id="copied"
            class="copied"
        ></span>

    </div>


    <!-- BILL NHIỀU SẢN PHẨM -->

    @if(!empty($multiPages))

        <div class="card multi-box">

            <div class="title">

                <div class="icon">
                    📦
                </div>

                <div>

                    <h2>
                        Bill nhiều sản phẩm
                    </h2>

                    <p>
                        Các bill nhiều sản phẩm được đưa lên đầu
                    </p>

                </div>

            </div>


            <input
                type="text"
                value="{{ $multiPages }}"
                readonly
                style="
                    width:100%;
                    padding:12px;
                    border:1px solid #fed7aa;
                    border-radius:8px;
                    background:white;
                "
            >

        </div>

    @endif


    <!-- DANH SÁCH -->

    <div class="card">

        <div class="products-header">

            <h2>
                📋 Danh sách sản phẩm
            </h2>

            <span class="badge">

                {{ count($groups) }} sản phẩm

            </span>

        </div>


        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th style="width:50px">
                            #
                        </th>

                        <th>
                            Sản phẩm
                        </th>

                        <th style="width:100px">
                            Số bill
                        </th>

                        <th style="width:35%">
                            Trang
                        </th>

                        <th style="width:100px">
                            Copy
                        </th>

                    </tr>

                </thead>


                <tbody>

                @forelse($groups as $product => $item)

                    <tr>

                        <td>

                            <strong>
                                {{ $loop->iteration }}
                            </strong>

                        </td>


                        <td>

                            <div class="product-name">

                                {{ $product }}

                            </div>

                        </td>


                        <td>

                            <span class="count">

                                {{ $item['count'] }}

                            </span>

                        </td>


                        <td>

                            <textarea
                                id="page{{ $loop->index }}"
                                readonly
                            >{{ $item['pages'] }}</textarea>

                        </td>


                        <td>

                            <button
                                class="copy-small"
                                onclick="
                                    copyPage(
                                        'page{{ $loop->index }}',
                                        this
                                    )
                                "
                            >
                                📋 Copy
                            </button>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="5"
                            class="empty"
                        >

                            Không có sản phẩm nào.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>


    <div class="footer">

        Powered by Phong.exe • Running on caffeine. ☕
        <br>
        <small>// Please don't Ctrl+C 😎</small>

    </div>

</div>


<script>

function copyPages()
{
    const input =
        document.getElementById('pageList');

    navigator.clipboard.writeText(
        input.value
    );

    document.getElementById('copied')
        .innerText =
        '✓ Đã sao chép!';

    setTimeout(function () {

        document.getElementById('copied')
            .innerText = '';

    }, 2000);
}


function copyPage(id, button)
{
    const textarea =
        document.getElementById(id);

    navigator.clipboard.writeText(
        textarea.value
    );

    const oldText =
        button.innerHTML;

    button.innerHTML =
        '✓ Đã copy';

    setTimeout(function () {

        button.innerHTML =
            oldText;

    }, 1500);
}

</script>

</body>

</html>