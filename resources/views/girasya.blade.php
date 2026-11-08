<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTER</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<body class="bg-light">

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        
        <div class="card shadow border-0 p-4" style="width: 100%; max-width: 400px; border-radius: 12px;">
            <div class="card-body">
                
                <h2 class="text-center fw-bold mb-4 text-dark">SIGN UP</h2>
                
                <form action="/input" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Username:</label>
                        <input type="text" name="u" id="name" class="form-control" required placeholder="Masukkan username">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email:</label>
                        <input type="email" name="e" id="email" class="form-control" required placeholder="Masukkan email">
                    </div>
                    
                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold">Password:</label>
                        <input type="password" name="p" id="password" class="form-control" required placeholder="Masukkan password">
                    </div>

                    <div class="mb-4">
                        <label for="foto" class="form-label fw-semibold">Foto Profil:</label>
                        <input type="file" name="foto" id="foto" class="form-control" accept="image/*" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 mb-2 py-2 fw-semibold">Daftar</button>
                    
                    <a href="/login" class="btn btn-outline-secondary w-100 py-2 fw-semibold">Sudah Punya Akun?</a>
                    
                </form>

            </div>
        </div>

    </div>

</body>
</html>
