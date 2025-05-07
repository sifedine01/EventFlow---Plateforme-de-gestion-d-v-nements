<?php
session_start();
require('config.php');

// Vérification des droits d'accès
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: connexion.php");
    exit;
}

// Inclure la bibliothèque FPDF
require('fpdf186/fpdf.php');

// Récupérer les événements
$stmt = $pdo->query("SELECT e.id, e.titre, e.date_event, e.lieu, e.statut, u.nom AS utilisateur 
                     FROM evenements e 
                     JOIN utilisateurs u ON e.utilisateur_id = u.id");
$evenements = $stmt->fetchAll();

// Création du PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Liste des evenements', 0, 1, 'C');

// En-tête du tableau
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 10, 'ID', 1);
$pdf->Cell(40, 10, 'Titre', 1);
$pdf->Cell(30, 10, 'Date', 1);
$pdf->Cell(30, 10, 'Lieu', 1);
$pdf->Cell(30, 10, 'Statut', 1);
$pdf->Cell(45, 10, 'Utilisateur', 1);
$pdf->Ln();

// Contenu du tableau
$pdf->SetFont('Arial', '', 10);
foreach ($evenements as $event) {
    $pdf->Cell(10, 10, $event['id'], 1);
    $pdf->Cell(40, 10, utf8_decode($event['titre']), 1);
    $pdf->Cell(30, 10, $event['date_event'], 1);
    $pdf->Cell(30, 10, utf8_decode($event['lieu']), 1);
    $pdf->Cell(30, 10, $event['statut'], 1);
    $pdf->Cell(45, 10, utf8_decode($event['utilisateur']), 1);
    $pdf->Ln();
}

// Télécharger le PDF
$pdf->Output('D', 'evenements.pdf');
?>