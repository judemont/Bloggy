<?php

$data = file_get_contents('infos.json');
$data = json_decode($data, true);
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $data["name"] ?></title>
        <link rel="stylesheet" href="styles/style.css">
    </head>
    <body>
        <header>
            <h1><?php echo $data["name"] ?></h1>
            <b><i><?php echo $data["description"] ?></i></b>
        </header>
        <h3 >Articles :</h3>
        <ul class="articles">
            <?php
            $directory = __DIR__ . '/articles/';
            $files = glob($directory . '*.md');
            $files = array_reverse($files);
            foreach ($files as $file) {
                $content = file_get_contents($file);

                preg_match('/\[info_title\]: (.+)/', $content, $titleMatch);
                preg_match('/\[info_description\]: (.+)/', $content, $descriptionMatch);
                preg_match('/\[info_date\]: (.+)/', $content, $dateMatch);

                $title = $titleMatch[1] ?? 'No title';
                $description = $descriptionMatch[1] ?? 'No description';
                $date = $dateMatch[1] ?? 'No date';
                
                $wordCount = str_word_count(strip_tags($content));
                $readTime = ceil($wordCount / 200) . ' min read';

                $fileName = basename($file);

                echo "
                <li>
                    <a href=\"read.php?p=$fileName\"><b>$title</b></a> <br>
                    <p>$description</p> 
                    <i>$date</i> <br>
                    <b>$readTime</b>
                </li><br>";
            }
            ?>
        </ul>
        <footer>
            <br><br>
            <p>Blogging Platforms by <a href="https://futureofthe.tech">JdM</a></p> <!-- You can remove this line if you want. -->
        </footer>
    </body>
</html>
