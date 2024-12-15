<?php
// Koneksi ke server 192.168.5.240 (database asal)
$source_conn = new mysqli("192.168.5.240", "id14269137_farhan123", "611281Eb15e*", "haebot1");

// Koneksi ke server tujuan
$destination_conn = new mysqli("localhost", "root", "", "business_management");

// Check koneksi sumber
if ($source_conn->connect_error) {
    die("Koneksi ke database asal gagal: " . $source_conn->connect_error);
}

// Check koneksi tujuan
if ($destination_conn->connect_error) {
    die("Koneksi ke database tujuan gagal: " . $destination_conn->connect_error);
}

// Query untuk mendapatkan data dari database asal
$source_query = "SELECT PRODUCT_NO, PRODUCT_NAME, PRICE_BASE FROM products";
$source_result = $source_conn->query($source_query);

if ($source_result->num_rows > 0) {
    while ($row = $source_result->fetch_assoc()) {
        // Persiapkan data untuk dimasukkan ke database tujuan
        $id = $row['PRODUCT_NO'];
        $name = $row['PRODUCT_NAME'];
        $price = $row['PRICE_BASE'];

        // Query untuk memasukkan data ke database tujuan
        $destination_query = $destination_conn->prepare(
            "INSERT INTO products (id, name, price) VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE name = VALUES(name), price = VALUES(price)"
        );

        $destination_query->bind_param("isd", $id, $name, $price);

        if ($destination_query->execute()) {
            echo "Data produk dengan ID $id berhasil dipindahkan. <br>";
        } else {
            echo "Gagal memindahkan data produk dengan ID $id: " . $destination_query->error . "<br>";
        }
    }
} else {
    echo "Tidak ada data ditemukan di database asal. <br>";
}

// Tutup koneksi
$source_conn->close();
$destination_conn->close();
?>
