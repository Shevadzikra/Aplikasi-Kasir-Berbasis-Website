<?php
require_once '../library/dompdf/autoload.inc.php';

$id_trx = $_GET['idtrx'];

// Reference the Dompdf namespace
use Dompdf\Dompdf;

// Instantiate and use the dompdf class
$dompdf = new Dompdf();

// Ambil konten struk dari file transaksi_selesai_pdf.php
ob_start();
require './transaksi_selesai_pdf.php';
$struk = ob_get_clean();
ob_end_clean();

$dompdf->loadHtml($struk);

// Hitung tinggi konten (dalam milimeter)
$jumlah_baris = substr_count($struk, '<tr>'); // Hitung jumlah baris di tabel
$tinggi_per_baris = 10; // Tinggi per baris dalam milimeter (sesuaikan dengan kebutuhan)
$tinggi_konten = $jumlah_baris * $tinggi_per_baris + 300; // Tambahkan margin 100mm untuk header dan footer

// Atur ukuran kertas (70mm lebar, tinggi dinamis)
$customPaper = array(0, 0, 204, $tinggi_konten); // Lebar 70mm, tinggi sesuai konten
$dompdf->setPaper($customPaper);

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream('Struk #' . $trx['nomor'].'.pdf', ["Attachment" => false]);
exit(0);
?>