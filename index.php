<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>کتابخانه عمومی کوثر منظریه رشت</title>
    <!-- Bootstrap CSS -->

    <link href="https://fonts.googleapis.com/css2?family=Vazir:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->

    <style>
        *{
            direction: rtl;
            font-family: 'Vazir',Arial, sans-serif;
        }

        body {
            font-family: 'Vazir',Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #343a40 !important;
        }
        .carousel-item {
            height: 600px;
            background-size: cover;
        }
        .footer {
            background-color: #343a40;
            color: #fff;
            padding: 30px 0;
            text-align: center;
        }
        .search-box {
            background-color: #f8f9fa;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 30px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark  fixed-top">
    <div class="container">
        <a class="navbar-brand" href="https://kowsarlib.giln.ir">کتابخانه کوثر رشت</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="https://kowsarlib.giln.ir">کتابخانه رشت <span class="sr-only"></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">کانال</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">عضویت</a>
                </li>
            </ul>
                <form class="form-inline my-2 my-lg-0" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                <input class="form-control mr-sm-2" type="search" placeholder="کلید واژه" aria-label="Search"  name="searchTerm">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">کنکاش</button>
            </form>
        </div>
    </div>
</nav>

<!-- Header with Slider -->
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active">Hello</li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active" style="background-image: url('slider1.png');">
            <!-- You can adjust the image URL to your slider image -->
        </div>
        <div class="carousel-item" style="background-image: url('slider2.png');">
            <!-- You can adjust the image URL to your slider image -->
        </div>
        <div class="carousel-item" style="background-image: url('slider1.png');">
            <!-- You can adjust the image URL to your slider image -->
        </div>
    </div>
</div>

<!-- Search Box -->
<div class="container-fluid mt-12">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="search-box">
                <h4 class="mb-4">Search</h4>
                <?php

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $searchTerm = $_POST["searchTerm"];

// Function to search for lines in a CSV file
                    function searchCSV($filename, $searchTerm)
                    {
                        $linesFound = array();

                        // Open the CSV file for reading
                        if (($handle = fopen($filename, "r")) !== FALSE) {
                            // Read each line of the CSV file
                            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                                // Convert each value to UTF-8
                                foreach ($data as &$value) {
                                    $value = mb_convert_encoding($value, "UTF-8", "auto");
                                }

                                // Check if the line contains the search term
                                foreach ($data as $value) {
                                    if (mb_stripos($value, $searchTerm) !== false) {
                                        // Add the line to the array of found lines
                                        $linesFound[] = $data;
                                        break; // Break out of the loop if the term is found in this line
                                    }
                                }
                            }
                            fclose($handle);
                        }

                        return $linesFound;
                    }

                    function getFirstLine($filename)
                    {
                        $firstLine = null;

                        // Open the CSV file for reading
                        if (($handle = fopen($filename, "r")) !== FALSE) {
                            // Read the first line of the CSV file
                            $firstLine = fgetcsv($handle, 1000, ",");
                            fclose($handle);
                        }
                        $return[] = $firstLine;
                        return $return;
                    }
                }
                ?>
                <h2 class="mb-12">جستجو در فایل CSV</h2>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group">
                        <label for="searchTerm">ترم جستجو:</label>
                        <input type="text" maxlength="30" size="30" required class="form-control" id="searchTerm" name="searchTerm" placeholder="مثال: کلمه" value="<?=$searchTerm?>">
                    </div>
                    <button type="submit" class="btn btn-primary">جستجو</button>
                </form>

                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Usage example:
                    $filename = 'fixed_Fehrest.csv';
                    $lines = searchCSV($filename, $searchTerm);
                    $firstline = getFirstLine($filename);
                    $print="";
                    // Display the found lines
                    if (!empty($lines)) {
                        $print.= "<h3 class='mt-4'>نتایج جستجو:</h3>";
                        $print.= "<div class='list-group table-responsive'>";
                        $print.= "<table  class=\"table table-striped sticky-top fixed-top\" >";
                        foreach ($firstline as $line) {
                            $width=100/count($line);
                            $strings= implode("</td><td> ",$line);
                            $print.= <<<EOF
<thead><tr><td style="width: $width%">$strings</td></tr></thead>\n
<tbody>
EOF;

                            // echo "<a href='#' class='list-group-item list-group-item-action'>$strings</a>";
                        }
                        foreach ($lines as $line) {
                            $alert_str="";
                            for ($i=0;$i<count($line);$i++)
                                $alert_str.=$firstline[0][$i].": ".$line[$i]."\\n";
                            $strings= implode("</td><td> ",$line);
                            $alert_str=str_ireplace('"','<>',$alert_str);
                            $alert_str=str_ireplace("'","\\'",$alert_str);
                            //$alert_str=urlencode($alert_str);
                            $print.= <<<EOF
<tr onclick="alert('$alert_str');" class="cursor-pointer" ><td class="cursor-pointer" >$strings</td></tr>\n
EOF;

                            // echo "<a href='#' class='list-group-item list-group-item-action'>$strings</a>";
                        }
                        $print.= "</tbody></table>";
                        $print.= "</div>";
                    } else {
                        $print.= "<p class='mt-4'>هیچ خطی با '$searchTerm' پیدا نشد.</p>";
                    }
                }
                echo $print;
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <p>&copy; 2022 Your Website</p>
    </div>
</footer>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
