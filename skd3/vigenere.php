<!DOCTYPE html>
<html>
<head>
    <title>Vigenere Cipher</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
<div class="container">
    <form method="post" action=""> 
        <h1>Vigenere Cipher</h1>
        <label for="plaintext">Masukkan Kalimat Asli</label>
        <input type="text" id="plaintext" name="plaintext" required><br>

        <label for="key">Masukkan Kata Kunci</label>
        <input type="text" id="key" name="key" required><br>

        <input type="submit" name="encrypt" value="Enkripsi">
        <input type="submit" name="decrypt" value="Deskripsi">
    </form>

    <?php
    // Fungsi untuk mengenkripsi teks menggunakan Vigenere Cipher
    function vigenereEncrypt($plaintext, $key) {
        $plaintext = strtoupper($plaintext);
        $key = strtoupper($key);
        $encryptedText = "";

        $plaintextLength = strlen($plaintext);
        $keyLength = strlen($key);

        for ($i = 0; $i < $plaintextLength; $i++) {
            $char = $plaintext[$i];
            if (ctype_alpha($char)) {
                $charIndex = ord($char) - ord('A');
                $keyChar = $key[$i % $keyLength];
                $keyIndex = ord($keyChar) - ord('A');
                $encryptedChar = chr(((($charIndex + $keyIndex) % 26) + ord('A')));
                $encryptedText .= $encryptedChar;
            } else {
                $encryptedText .= $char;
            }
        }

        return $encryptedText;
    }

    // Fungsi untuk mendekripsi teks yang telah dienkripsi menggunakan Vigenere Cipher

    function vigenereDecrypt($encryptedText, $key) {
        $encryptedText = strtoupper($encryptedText);
        $key = strtoupper($key);
        $decryptedText = "";

        $encryptedTextLength = strlen($encryptedText);
        $keyLength = strlen($key);

        for ($i = 0; $i < $encryptedTextLength; $i++) {
            $char = $encryptedText[$i];
            if (ctype_alpha($char)) {
                $charIndex = ord($char) - ord('A');
                $keyChar = $key[$i % $keyLength];
                $keyIndex = ord($keyChar) - ord('A');
                $decryptedChar = chr((((($charIndex - $keyIndex) + 26) % 26) + ord('A')));
                $decryptedText .= $decryptedChar;
            } else {
                $decryptedText .= $char;
            }
        }

        return $decryptedText;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $plaintext = $_POST["plaintext"];
        $key = $_POST["key"];

        if (isset($_POST["encrypt"])) {
            $encryptedText = vigenereEncrypt($plaintext, $key);
            echo "<p>Hasil Enkripsi : $encryptedText</p>"; //menampilkan hasil enkripsi
        } elseif (isset($_POST["decrypt"])) {
            $decryptedText = vigenereDecrypt($plaintext, $key);
            echo "<p>Hasil Deskripsi : $decryptedText</p>"; //menampilkan hasil deskripsi
        }
    }
    ?>
</div>
</body>
</html>
