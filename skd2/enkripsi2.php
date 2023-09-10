<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Panggil fungsi enkripsi jika ada permintaan POST
    enkripsi();
}

function enkripsi()
{
    // Ambil input dari form
    $input = $_POST["input"];

    // Fungsi untuk mengenkripsi dengan metode pergeseran Caesar Cipher sebesar 3
    function caesarCipher($text, $shift)
    {
        $result = '';

        // Loop melalui setiap karakter dalam teks
        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];

            // Periksa apakah karakter adalah huruf atau angka
            if (ctype_alpha($char)) {
                // Tentukan apakah karakter adalah huruf besar atau huruf kecil
                $isUpperCase = ctype_upper($char);
                $char = ord($char); // Ubah karakter menjadi kode ASCII

                // Terapkan pergeseran (Caesar Cipher) sebesar 3
                $char = $char + $shift;

                // Periksa apakah pergeseran melebihi batas huruf (z atau Z)
                if ($isUpperCase && $char > ord('Z')) {
                    $char = $char - 26; // Kembali ke awal alfabet besar
                } elseif (!$isUpperCase && $char > ord('z')) {
                    $char = $char - 26; // Kembali ke awal alfabet kecil
                }

                // Kembalikan huruf besar atau huruf kecil sesuai dengan aslinya
                if ($isUpperCase) {
                    $char = strtoupper(chr($char));
                } else {
                    $char = chr($char);
                }
            } elseif (ctype_digit($char)) {
                // Jika karakter adalah angka, terapkan pergeseran
                $char = ($char - '0' + $shift) % 10 + '0';
            }

            // Tambahkan karakter ke hasil enkripsi
            $result .= $char;
        }

        return $result;
    }

    // Panggil fungsi Caesar Cipher dengan pergeseran 3
    $enkripsi = caesarCipher($input, 3);

    // Tampilkan hasil enkripsi
    echo "<div class='output-box'>";
    echo "<p>Kata Plain Text : ", $input, "</p>";
    echo "<p>Cipher Text : ", $enkripsi, "</p>";
    echo "</div>";
}
?>
</body>
</html>


