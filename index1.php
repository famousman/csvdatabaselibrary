<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>کتابخانه کوثر مسجد فاطمیه منظریه رشت</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        *{

            direction: rtl;
        }
        body {
            direction: rtl;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>
</head>
<body>
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

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
