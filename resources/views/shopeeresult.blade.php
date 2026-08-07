<!doctype html>
<html lang="vi">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Kết quả Shopee - Bill Sorter</title>


    <style>
        * {
            box-sizing: border-box;
        }


        body {
            margin: 0;
            min-height: 100vh;

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            background:
                linear-gradient(135deg,
                    #f5f7ff,
                    #eef2ff);

            color: #1f2937;
        }


        .container {
            width: 92%;
            max-width: 900px;

            margin: 50px auto;
        }


        /* HEADER */

        .header {
            text-align: center;

            margin-bottom: 30px;
        }


        .header-icon {
            width: 60px;
            height: 60px;

            margin: 0 auto 15px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 16px;

            background: #fff1f2;

            color: #ee4d2d;

            font-size: 30px;
        }


        .header h1 {
            margin: 0;

            font-size: 30px;

            color: #111827;
        }


        .header p {
            margin: 8px 0 0;

            color: #6b7280;

            font-size: 15px;
        }


        /* SUCCESS */

        .success-card {
            background: white;

            border-radius: 16px;

            padding: 18px 22px;

            margin-bottom: 20px;

            display: flex;

            align-items: center;

            gap: 14px;

            box-shadow:
                0 8px 25px rgba(0, 0, 0, .06);

            border-left:
                5px solid #22c55e;
        }


        .success-icon {
            width: 40px;
            height: 40px;

            border-radius: 50%;

            background: #dcfce7;

            color: #16a34a;

            display: flex;

            align-items: center;
            justify-content: center;

            font-size: 20px;
        }


        .success-text strong {
            display: block;

            color: #15803d;

            font-size: 15px;

            margin-bottom: 3px;
        }


        .success-text span {
            color: #6b7280;

            font-size: 13px;
        }


        /* MAIN CARD */

        .card {
            background: white;

            border-radius: 16px;

            padding: 28px;

            box-shadow:
                0 8px 30px rgba(0, 0, 0, .07);
        }


        .card-title {
            display: flex;

            align-items: center;

            gap: 12px;

            margin-bottom: 20px;
        }


        .card-icon {
            width: 45px;
            height: 45px;

            border-radius: 11px;

            background: #eef2ff;

            display: flex;

            align-items: center;
            justify-content: center;

            font-size: 21px;
        }


        .card-title h2 {
            margin: 0;

            font-size: 21px;

            color: #111827;
        }


        .card-title p {
            margin: 4px 0 0;

            color: #6b7280;

            font-size: 13px;
        }


        /* PAGE LIST */

        .page-wrapper {
            position: relative;
        }


        textarea {
            width: 100%;

            min-height: 130px;

            resize: vertical;

            padding: 15px;

            border: 1px solid #d1d5db;

            border-radius: 10px;

            background: #f9fafb;

            color: #111827;

            font-family:
                Consolas,
                monospace;

            font-size: 15px;

            line-height: 1.6;

            outline: none;
        }


        textarea:focus {
            border-color: #6366f1;

            background: white;

            box-shadow:
                0 0 0 3px rgba(99, 102, 241, .1);
        }


        /* ACTION */

        .actions {
            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-top: 15px;

            gap: 15px;
        }


        .total {
            color: #6b7280;

            font-size: 14px;
        }


        .total strong {
            color: #111827;

            font-size: 20px;

            margin-left: 5px;
        }


        .copy-button {
            background: #4f46e5;

            color: white;

            padding: 11px 20px;

            border-radius: 9px;

            border: none;

            font-size: 14px;

            font-weight: 600;

            cursor: pointer;

            transition: .2s ease;
        }


        .copy-button:hover {
            background: #4338ca;

            transform:
                translateY(-1px);
        }


        .copy-button.copied {
            background: #16a34a;
        }


        /* INFO */

        .info {
            margin-top: 20px;

            padding: 14px 16px;

            border-radius: 9px;

            background: #f8fafc;

            color: #64748b;

            font-size: 13px;

            line-height: 1.5;
        }


        /* FOOTER */

        .footer {
            text-align: center;

            margin-top: 25px;

            color: #9ca3af;

            font-size: 13px;
        }


        /* MOBILE */

        @media (max-width: 600px) {

            .container {
                width: 94%;

                margin: 25px auto;
            }


            .card {
                padding: 20px;
            }


            .header h1 {
                font-size: 26px;
            }


            .actions {
                flex-direction: column;

                align-items: stretch;
            }


            .copy-button {
                width: 100%;
            }


            .total {
                text-align: center;
            }

        }
    </style>

</head>


<body>


    <div class="container">


        <!-- HEADER -->

        <div class="header">

            <div class="header-icon">
                🛍️
            </div>

            <h1>
                Kết quả Bill Shopee
            </h1>

            <p>
                Bill Sorter - Kết quả sắp xếp trang
            </p>

        </div>


        <!-- SUCCESS -->

        <div class="success-card">

            <div class="success-icon">
                ✓
            </div>

            <div class="success-text">

                <strong>
                    Đã sắp xếp thành công!
                </strong>

                <span>
                    Thứ tự các trang đã được xử lý và sắp xếp.
                </span>

            </div>

        </div>


        <!-- RESULT -->

        <div class="card">


            <div class="card-title">

                <div class="card-icon">
                    📄
                </div>

                <div>

                    <h2>
                        Thứ tự trang cần in
                    </h2>

                    <p>
                        Sao chép danh sách bên dưới để sử dụng.
                    </p>

                </div>

            </div>


            <!-- PAGE LIST -->

            <div class="page-wrapper">

                <textarea
                    id="pagesToPrint"
                    readonly>{{ $pagesToPrint }}</textarea>

            </div>


            <!-- ACTION -->

            <div class="actions">


                <div class="total">

                    Tổng số bill:

                    <strong>
                        {{ $pagesToPrint ? count(explode(',', $pagesToPrint)) : 0 }}
                    </strong>

                </div>


                <button
                    class="copy-button"
                    id="copyButton"
                    onclick="copyPages()">

                    📋 Sao chép thứ tự trang

                </button>


            </div>


            <!-- INFO -->

            <div class="info">

                💡 <strong>Lưu ý:</strong>
                Thứ tự trang phía trên là thứ tự đã được hệ thống
                sắp xếp. Bạn có thể sao chép trực tiếp và sử dụng
                khi in bill.

            </div>


        </div>


        <!-- FOOTER -->

        <div class="footer">
            Powered by Phong.exe • Running on caffeine. ☕
            <br>
            <small>// Please don't Ctrl+C 😎</small>
        </div>


    </div>


    <script>
        function copyPages() {

            const textarea =
                document.getElementById(
                    "pagesToPrint"
                );


            const button =
                document.getElementById(
                    "copyButton"
                );


            const text =
                textarea.value.trim();


            if (!text) {

                alert(
                    "Không có trang nào để sao chép!"
                );

                return;
            }


            navigator.clipboard
                .writeText(text)

                .then(function() {

                    button.innerHTML =
                        "✓ Đã sao chép!";

                    button.classList.add(
                        "copied"
                    );


                    setTimeout(
                        function() {

                            button.innerHTML =
                                "📋 Sao chép thứ tự trang";

                            button.classList.remove(
                                "copied"
                            );

                        },
                        2000
                    );

                })

                .catch(function() {

                    textarea.select();

                    document.execCommand(
                        "copy"
                    );


                    button.innerHTML =
                        "✓ Đã sao chép!";

                    button.classList.add(
                        "copied"
                    );


                    setTimeout(
                        function() {

                            button.innerHTML =
                                "📋 Sao chép thứ tự trang";

                            button.classList.remove(
                                "copied"
                            );

                        },
                        2000
                    );

                });

        }
    </script>


</body>

</html>