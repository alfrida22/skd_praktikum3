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
    // Fungsi untuk menghasilkan matriks kunci dari kunci yang diberikan
    function generateKeyMatrix($key) {
        $key = strtoupper($key);
        $key = preg_replace("/[^A-Z]/", "", $key); // Hapus karakter yang bukan huruf kapital
        $key = str_replace("J", "I", $key); // Ganti J dengan I
        $key = str_split($key);

        $alphabet = "ABCDEFGHIKLMNOPQRSTUVWXYZ"; // Alfabet Playfair tanpa J

        // Inisialisasi matriks kunci
        $keyMatrix = array();
        $keyLength = count($key);
        $alphabetLength = strlen($alphabet);

        // Isi matriks kunci dengan karakter dari kunci
        for ($i = 0; $i < $keyLength; $i++) {
            if (!in_array($key[$i], $keyMatrix)) {
                array_push($keyMatrix, $key[$i]);
            }
        }

        // Isi matriks kunci dengan sisa alfabet
        for ($i = 0; $i < $alphabetLength; $i++) {
            if (!in_array($alphabet[$i], $keyMatrix)) {
                array_push($keyMatrix, $alphabet[$i]);
            }
        }

        return $keyMatrix;
    }

    // Fungsi untuk mendekripsi teks
    function decrypt($ciphertext, $keyMatrix) {
        $ciphertext = strtoupper($ciphertext);
        $ciphertext = preg_replace("/[^A-Z]/", "", $ciphertext); // Hapus karakter yang bukan huruf kapital
        $ciphertext = str_split($ciphertext);

        $plaintext = "";

        $textLength = count($ciphertext);

        for ($i = 0; $i < $textLength; $i += 2) {
            $char1 = $ciphertext[$i];
            $char2 = ($i + 1 < $textLength) ? $ciphertext[$i + 1] : "X";

            // Temukan posisi karakter dalam matriks kunci
            $pos1 = array_search($char1, $keyMatrix);
            $pos2 = array_search($char2, $keyMatrix);

            // Hitung baris dan kolom karakter
            $row1 = (int)($pos1 / 5);
            $col1 = $pos1 % 5;
            $row2 = (int)($pos2 / 5);
            $col2 = $pos2 % 5;

            // Jika karakter pada baris yang sama, geser ke kiri
            if ($row1 == $row2) {
                $col1 = ($col1 - 1 + 5) % 5;
                $col2 = ($col2 - 1 + 5) % 5;
            }
            // Jika karakter pada kolom yang sama, geser ke atas
            elseif ($col1 == $col2) {
                $row1 = ($row1 - 1 + 5) % 5;
                $row2 = ($row2 - 1 + 5) % 5;
            }
            // Jika tidak, tukar kolom
            else {
                $temp = $col1;
                $col1 = $col2;
                $col2 = $temp;
            }

            // Hasil dekripsi
            $plaintext .= $keyMatrix[$row1 * 5 + $col1] . $keyMatrix[$row2 * 5 + $col2];
        }

        return $plaintext;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["decryptionKey"]) && isset($_POST["ciphertext"])) {
            $key = $_POST["decryptionKey"];
            $ciphertext = $_POST["ciphertext"];
    
            // Generate key matrix
            $keyMatrix = generateKeyMatrix($key);
    
            // Decrypt text
            $decryptedText = decrypt($ciphertext, $keyMatrix);
            echo "<p>Ciphertext : $ciphertext</p>";
            echo "<p>Plaintext : $decryptedText</p>";
        } else {
            echo "<p>Silakan masukkan kunci dan ciphertext melalui formulir.</p>";
        }
    }
?>
</body>
</html>
