<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Example</title>

    <!-- Import toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <!-- Optionally, you can add custom styles here -->
    <style>
        body {
            height: 100vh; /* Set body height to 100% of the viewport height */
            margin: 0; /* Remove default margin */
            display: flex;
            flex-direction: column;
            justify-content: center; /* Center content vertically */
            align-items: center; /* Center content horizontally */
            background-color: #f5f5f5; /* Optional background color */
        }
        
        .content {
            padding: 10px; /* Optional padding for content */
            text-align: center;
        }
    </style>
</head>
<body >
    <div>
        <h1>Halaman dengan Notifikasi</h1>
        <!-- Konten lainnya -->
    </div>

    <!-- Menambahkan toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script>
        @if(session('toast'))
            toastr.error('{{ session('toast') }}');  // Menampilkan toast error
        @endif
    </script>
</body>
</html>
