<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body>
    <form action="/run.php" method="post">
        <div class="mb-3">
            <label for="firm" class="form-label">Firma, Kuruluş Tipi</label>
            <input type="text" class="form-control" id="firm" name="firm" aria-describedby="firmHelp" placeholder="Otel">
            <div id="firmHelp" class="form-text">Otel vb.</div>
        </div>
        <div class="mb-3">
            <label for="where" class="form-label">Yer</label>
            <input type="text" class="form-control" id="where" name="where" aria-describedby="firmHelp" placeholder="Alanya">
            <div id="whereHelp" class="form-text">Alanya vb.</div>
        </div>
        <div class="mb-3">
            <label for="page" class="form-label">Yer</label>
            <input type="text" class="form-control" id="page" name="page" aria-describedby="firmHelp" placeholder="0" value="0">
            <div id="pageHelp" class="form-text">Başlangıç değeri 0.</div>
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Çalıştır</button>
        </div>
    </form>
</body>
</html>
