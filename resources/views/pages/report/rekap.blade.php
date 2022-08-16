<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Rekap</title>
</head>
<body>
    <?php
        use App\Models\MJenisAdministrasi;
        use App\Models\MKelas;
        $mJenisAdm = MJenisAdministrasi::all();
        $mKelas = MKelas::all();
    ?>
    @foreach($mJenisAdm as $jenisAdm)
        
    @endforeach
</body>
</html>