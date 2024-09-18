<?php

// Mostrar errores para depuración (quitar en producción)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Asegurarse de que no se está enviando ninguna salida antes de las cabeceras
ob_start();

// Cargar FPDF
require('fpdf/fpdf.php');

// Configurar cabeceras para la descarga del PDF
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="eventos_reporte.pdf"');
header('Cache-Control: private, max-age=0, must-revalidate');
header('Pragma: public');

// Iniciar FPDF y cabecera
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12); // Usar Arial en lugar de helvetica para evitar problemas

// Encabezado de la empresa
$pdf->Cell(80);
$pdf->Cell(30, 10, 'Sistema de Gestion de Eventos Deportivos', 0, 1, 'C');
$pdf->Ln(10);

// Datos del organizador del evento (datos ingresados manualmente)
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 10, 'Datos del Organizador', 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 6, 'Nombre: Francisco Quinteros', 0, 1, 'L');
$pdf->Cell(0, 6, 'Correo: organizador@eventos.com', 0, 1, 'L');
$pdf->Cell(0, 6, 'Direccion: Calle Deportiva 123, Quito, Ecuador', 0, 1, 'L');
$pdf->Ln(10);

// Título de la tabla de eventos
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 10, 'Lista de Eventos', 0, 1, 'L');

// Crear tabla de eventos
$header = array('#', 'Nombre del Evento', 'Fecha', 'Lugar', 'Participantes');
$widths = array(10, 70, 30, 40, 40);

$pdf->SetFont('Arial', 'B', 9);
for ($i = 0; $i < count($header); $i++) {
    $pdf->Cell($widths[$i], 7, $header[$i], 1, 0, 'C');
}
$pdf->Ln();

$pdf->SetFont('Arial', '', 9);
$index = 1;

$eventos = [
    ['Nombre' => 'Carrera 5K', 'Fecha' => '2024-09-30', 'Lugar' => 'Parque La Carolina', 'Participantes' => 150],
    ['Nombre' => 'Torneo de Futbol', 'Fecha' => '2024-10-15', 'Lugar' => 'Estadio Olímpico', 'Participantes' => 200],
    ['Nombre' => 'Maratón Quito', 'Fecha' => '2024-11-20', 'Lugar' => 'Centro Histórico', 'Participantes' => 300],
];

foreach ($eventos as $evento) {
    $pdf->Cell($widths[0], 6, $index, 1);
    $pdf->Cell($widths[1], 6, $evento["Nombre"], 1);
    $pdf->Cell($widths[2], 6, $evento["Fecha"], 1);
    $pdf->Cell($widths[3], 6, $evento["Lugar"], 1);
    $pdf->Cell($widths[4], 6, number_format($evento["Participantes"], 0), 1, 0, 'R');
    $pdf->Ln();
    $index++;
}

// Espacio para más información (Inscripciones y Participantes)
// Puedes agregar más secciones de reportes según sea necesario para Inscripciones y Participantes.

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 10, 'Reporte Generado para el Sistema de Gestion de Eventos Deportivos', 0, 1, 'L');

// Limpiar el buffer de salida antes de enviar el PDF
ob_end_clean();
$pdf->Output('I', 'eventos_reporte.pdf');

// OTRA FORMA DE HACER EL PDF 
/* <?php
// Mostrar errores para depuración (solo en desarrollo, quitar en producción)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Asegurarse de que no se está enviando ninguna salida antes de las cabeceras
ob_start();

if (!defined('FPDF_FONTPATH')) {
    define('FPDF_FONTPATH', dirname(__FILE__) . '/font/');
}

// Cargar FPDF
require('fpdf/fpdf.php');
require_once("../models/eventos.model.php");
require_once("../config/config.php");

// Crear conexión a la base de datos
$con = new ClaseConectar();
$conexion = $con->ProcedimientoParaConectar();
if (!$conexion) {
    die('Error de conexión a la base de datos');
}

// Crear instancia de la clase Evento
$eventos = new Evento($conexion);
$listaEventos = $eventos->todos();

// Verifica si hay eventos antes de proceder
if (!$listaEventos || mysqli_num_rows($listaEventos) === 0) {
    die('No se encontraron eventos para generar el reporte');
}

// Configurar cabeceras para la descarga del PDF
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="eventos_reporte.pdf"');
header('Cache-Control: private, max-age=0, must-revalidate');
header('Pragma: public');

// Iniciar FPDF y cabecera
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Helvetica', 'B', 12);

// Encabezado de la empresa
$pdf->Cell(80);
$pdf->Cell(30, 10, 'Sistema de Gestión de Eventos Deportivos', 0, 1, 'C');
$pdf->Ln(10);

// Datos del reporte
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->Cell(0, 10, 'Reporte de Eventos', 0, 1, 'L');
$pdf->SetFont('Helvetica', '', 10);
$pdf->Cell(0, 6, 'Generado por: Francisco Quinteros', 0, 1, 'L');
$pdf->Ln(10);

// Título de la tabla de eventos
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->Cell(0, 10, 'Lista de Eventos', 0, 1, 'L');

// Crear tabla de eventos
$header = array('#', 'Nombre', 'Fecha', 'Ubicación', 'Descripción');
$widths = array(10, 50, 30, 50, 50);

$pdf->SetFont('Helvetica', 'B', 9);
for ($i = 0; $i < count($header); $i++) {
    $pdf->Cell($widths[$i], 7, $header[$i], 1, 0, 'C');
}
$pdf->Ln();

$pdf->SetFont('Helvetica', '', 9);
$index = 1;

// Generar filas de eventos
while ($evento = mysqli_fetch_assoc($listaEventos)) {
    $pdf->Cell($widths[0], 6, $index, 1);
    $pdf->Cell($widths[1], 6, $evento["nombre"], 1);
    $pdf->Cell($widths[2], 6, $evento["fecha"], 1);
    $pdf->Cell($widths[3], 6, $evento["ubicacion"], 1);
    $pdf->Cell($widths[4], 6, $evento["descripcion"], 1);
    $pdf->Ln();
    $index++;
}

// Enviar salida del PDF
ob_end_clean(); // Limpiar el buffer de salida antes de enviar el PDF
$pdf->Output('I', 'eventos_reporte.pdf');
?>
*/
?>
