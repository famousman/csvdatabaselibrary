<?php
$keywords=array(
    "0" => "آ",
    "1" => "ا",
    "4" => "ب",
    "5" => "ب",
    "6" => "پ",
    "8" => "ت",
    "9" => "ت",
    ":" => "ث",
    "<" => "ج",
    "=" => "ج ",
    ">" => "چ",
    "@" => "ح",
    "B" => "خ",
    "C" => "خ",
    "D" => "د",
    "E" => "ذ",
    "F" => "ر",
    "G" => "ز",
    "H" => "ژ",
    "I" => "س",
    "J" => "س ",
    "K" => "ش",
    "L" => "ش ",
    "M" => "ص",
    "N" => "ص ",
    "O" => "ض",
    "P" => "ض ",
    "Q" => "ط",
    "R" => "ط ",
    "S" => "ظ",
    "T" => "ظ ",
    "U" => "ع",
    "V" => "ع ",
    "W" => "غ",
    "X" => "غ ",
    "Y" => "ف",
    "Z" => "ف ",
    "[" => "ق",
    "\\" => "ق ",
    "]" => "ک",
    "_" => "گ",
    "`" => "گ",
    "a" => "ل",
    "b" => "ل ",
    "/" => "، ",
    "d" => "م",
    "c" => "م",
    "f" => "ن ",
    "e" => "ن",
    "g" => "و",
    "i" => "ه",
    "j" => "ه ",
    "l" => "ی",
    "m" => "ی ",
    "/" => "ئ",
    "w" => "لا",
    "ZZ" => "ح",
    "ZZ" => "ح",
    "ZZ" => "ح",
    "  " => " ",
);
/*
i ه اول
j ه آخر
l ی وسط
m ی آخر
/ ئ
)

 * */

$directory = './';
$msg="";
// Check if the directory exists
if (is_dir($directory)) {
    // Get the list of files and directories in the specified directory
    $files = scandir($directory);

    // Filter out only the files from the list
    $files = array_filter($files, function($file) use ($directory) {
        $ext=explode(".",$file);
        if(end($ext)=="csv")
            return is_file($directory . '/' . $file);
    });

    // Output the list of files
    $msg.= "Files in directory $directory:\n";
    foreach ($files as $file) {
        $main= file_get_contents($file);
        $counts=count($keywords);
        $replaced=$main;
        foreach ($keywords as $key => $value){
            $replaced=str_replace("".$key,$value,$replaced);
        }
        $fixed_file="fixed_".$file;
        if (file_put_contents($fixed_file, $replaced) !== false) {
            $msg.= "File ($fixed_file) created successfully.\n";
        } else {
            $msg.= "Error ($fixed_file) creating file.\n";
        }
        //echo  nl2br($replaced);
    }
} else {
    $msg.= "Directory $directory does not exist.\n";
}
echo  nl2br($msg);