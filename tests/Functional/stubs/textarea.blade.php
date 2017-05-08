<!DOCTYPE html>

<html lang="en-GB">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">

    <title>Laravel HTMLMin Test Page</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="A simple HTML minifier for Laravel 5" name="description">
    <meta content="Graham Campbell" name="author">
    <link href="http://example.com/favicon.ico" rel="shortcut icon">
</head>

<body>
    <div class="container">
        <h1>Laravel HTMLMin Test Page</h1>

        <p>A simple HTML minifier for Laravel 5</p>
        <form action="HelloWorld.php">
            
            <textarea name="thisisAtextarea">
                hello

                this is a space

                more space
                    a tab
                    {
                    haha some braces
                    }
            </textarea>

            <script type="text/javascript">
                $(document).ready(function() {

            var url = window.location;
            $('ul.nav a').filter(function() {
                return this.href == url;
            }).parent().addClass('active');

            $('.date-picker').datepicker({
                todayBtn: "linked"
            });

        });
            </script>

            <pre>

            this

            is a pre tag
            </pre>

        </form>
    </div>
</body>
</html>