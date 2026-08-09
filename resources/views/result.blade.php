<!DOCTYPE html>
<html lang="vi">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Bill TikTok đã sắp xếp</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px 15px;

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            background: #f5f7fb;

            color: #111827;
        }

        .container {
            width: 900px;
            max-width: 100%;
            margin: auto;
        }

        .card {
            background: white;

            border-radius: 14px;

            padding: 25px;

            margin-bottom: 20px;

            box-shadow:
                0 5px 20px
                rgba(0,0,0,.06);
        }

        h1 {
            margin-top: 0;
        }

        .success {
            padding: 15px;

            border-radius: 10px;

            background: #ecfdf5;

            color: #047857;

            margin-bottom: 20px;
        }

        .download {
            display: inline-block;

            padding: 13px 20px;

            border-radius: 9px;

            background: #111827;

            color: white;

            text-decoration: none;

            font-weight: bold;
        }

        .download:hover {
            opacity: .9;
        }

        .back {
            display: inline-block;

            margin-left: 8px;

            padding: 13px 20px;

            border-radius: 9px;

            background: #e5e7eb;

            color: #111827;

            text-decoration: none;
        }

        table {
            width: 100%;

            border-collapse: collapse;

            margin-top: 20px;
        }

        th,
        td {
            padding: 12px;

            border-bottom:
                1px solid #e5e7eb;

            text-align: left;
        }

        th {
            background: #f9fafb;
        }

        .page-list {
            word-break: break-word;

            background: #f9fafb;

            padding: 15px;

            border-radius: 8px;

            font-size: 14px;
        }

        .multi {
            margin-top: 20px;

            padding: 15px;

            background: #fff7ed;

            color: #c2410c;

            border-radius: 10px;
        }

        @media (max-width: 700px) {

            body {
                padding: 15px 10px;
            }

            .card {
                padding: 18px;
            }

            table {
                font-size: 13px;
            }

        }

    </style>

</head>

<body>

<div class="container">

    <div class="card">

        <h1>
            🎵 TikTok Bill đã sắp xếp
        </h1>

        <div class="success">

            ✅ Đã xử lý PDF thành công!

        </div>

        <a
            href="{{ route('tiktok.download') }}"
            class="download"
        >
            ⬇️ Tải PDF đã sắp xếp
        </a>

        <a
            href="{{ route('home') }}"
            class="back"
        >
            ← Làm tiếp
        </a>

    </div>


    <div class="card">

        <h2>
            📄 Thứ tự bill
        </h2>

        <div class="page-list">

            {{ $pageList }}

        </div>

    </div>


    @if($groups->count())

        <div class="card">

            <h2>
                📦 Nhóm sản phẩm
            </h2>

            <table>

                <thead>

                    <tr>

                        <th>
                            Sản phẩm
                        </th>

                        <th>
                            Số bill
                        </th>

                        <th>
                            Trang gốc
                        </th>

                    </tr>

                </thead>

                <tbody>

                @foreach($groups as $product => $group)

                    <tr>

                        <td>
                            {{ $product }}
                        </td>

                        <td>
                            {{ $group['count'] }}
                        </td>

                        <td>
                            {{ $group['pages'] }}
                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>

    @endif


    @if(!empty($multiPages))

        <div class="card">

            <div class="multi">

                📦 <strong>Bill nhiều sản phẩm:</strong>

                {{ $multiPages }}

            </div>

        </div>

    @endif

</div>

</body>

</html>