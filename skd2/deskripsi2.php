<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style3.css">
</head>
<body>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Panggil fungsi dekripsi jika ada permintaan POST
    dekripsi();
}

function dekripsi()
{
    // Ambil input cipher text dari form
    $cipherText = $_POST["input"];

    // Fungsi untuk mendekripsi metode pergeseran Caesar Cipher sebesar 3
    function caesarDecipher($text, $shift)
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

                // Terapkan dekripsi Caesar Cipher sebesar 3 (pergeseran negatif)
                $char = $char - $shift;

                // Periksa apakah pergeseran melebihi batas huruf (z atau Z)
                if ($isUpperCase && $char < ord('A')) {
                    $char = $char + 26; // Kembali ke akhir alfabet besar
                } elseif (!$isUpperCase && $char < ord('a')) {
                    $char = $char + 26; // Kembali ke akhir alfabet kecil
                }

                // Kembalikan huruf besar atau huruf kecil sesuai dengan aslinya
                if ($isUpperCase) {
                    $char = strtoupper(chr($char));
                } else {
                    $char = chr($char);
                }
            } elseif (ctype_digit($char)) {
                // Jika karakter adalah angka, terapkan pergeseran
                $char = ($char - '0' - $shift + 10) % 10 + '0';
            }

            // Tambahkan karakter ke hasil dekripsi
            $result .= $char;
        }

        return $result;
    }

    // Panggil fungsi Caesar Decipher dengan pergeseran 3 untuk mendekripsi cipher text menjadi plain text
    $plainText = caesarDecipher($cipherText, 3);

    // Tampilkan hasil dekripsi
    echo "<div class='output-box'>";
    echo "<p>Cipher Text : ", $cipherText, "</p>";
    echo "<p>Plain Text : ", $plainText, "</p>";
    echo "</div>";
};
?>
</body>
</html>
