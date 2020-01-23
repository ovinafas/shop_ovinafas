<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>File uploads</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>

    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <div class="content">
                <form action="/process" enctype="multipart/form-data" method="POST">
                    <p>
                        <label for="photo">
                            <input type="file" name="photo" id="photo">
                        </label>
                    </p>
                    <button>Upload</button>
                    @csrf
                </form>
                
            <?php
                $nodes = \App\Category::get()->toTree();

                $traverse = function ($categories, $prefix = '–') use (&$traverse) {
                    foreach ($categories as $category) {
                        echo "<option value=".$category->id.">".$prefix.' '.$category->name."</option>";
                        $traverse($category->children, $prefix.'-');
                    }
                };
                echo '<select name="categories[]" id="categories" class="form-control" multiple>';
                $traverse($nodes);
    
                $traver = function ($categories, $prefix = '–') use (&$traver) {
                   $ops = '';
                       foreach ($categories as $category) {
                           $ops .= "<option value=".$category->id.">".$prefix.' '.$category->name."</option>";
                           $ops .= $traver($category->children, $prefix.'-');
                       }
                       return $ops;
                   };
                    
                   $n = $traver($nodes);

                echo "</select>";
               
                ?>
                <select name="categories[]" id="categories" class="form-control" multiple>
                {!! $n !!}
                </select>
            </div>
        </div>
    </body>
</html>
