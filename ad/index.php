<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>C-Score</title>
        <link href="https://github.com/necolas/normalize.css/blob/master/normalize.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/css/materialize.min.css">
        <link href="style.css" rel="stylesheet">
    </head>
    <body onload="executeA('scorelist','../php/db_output.php','noparam=noparam','get');"> 
        <a style="text-align:center;font-size:2em;" target="_self" href="option.php">各チームの設定をする</a>
        <div style="text-align:center;font-size:2em;" class="container centered" id="display"></div>
        <table class="container centered">
            <thead>
                <tr>
                    <th>チーム名</th>
                    <th>ポイント</th>
                </tr>
            </thead>
            <tbody id="scorelist">
            </tbody>
        </table>
        
        
        <script src="https://ajax.googleapis.com/ajax/libs/prototype/1.7.3.0/prototype.js"></script>
        <script src="../js/ajax.js"></script>
    </body>
</html>