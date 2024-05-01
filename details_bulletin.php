<?php
include 'config.php';
require_once (__DIR__ . '/tcpdf/tcpdf.php');

if (isset($_POST['generate_pdf'])) {
    generatePDF();
}

function generatePDF()
{
    global $conn;
    require_once ('tcpdf/tcpdf.php');

    class BulletinPaiePDF extends TCPDF
    {
        public function Header()
        {
            $this->SetFont('helvetica', 'B', 12);
            $this->Cell(0, 10, 'Bulletin de Paie', 0, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Ln(10);
        }

        public function Footer()
        {
            $this->SetY(-15);
            $this->SetFont('helvetica', 'I', 8);
            $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        }
    }

    $pdf = new BulletinPaiePDF();

    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Votre Nom');
    $pdf->SetTitle('Bulletin de Paie');
    $pdf->SetSubject('Détails du Bulletin de Paie');
    $pdf->SetKeywords('Bulletin de Paie, PDF, PHP, TCPDF');

    $pdf->AddPage();

    if (isset($_GET['id'])) {
        $bulletin_id = $_GET['id'];

        $sql_details_bulletin = "SELECT * FROM bulletinpaie WHERE idBulletin = $bulletin_id";
        $result_details_bulletin = mysqli_query($conn, $sql_details_bulletin);

        if ($result_details_bulletin && mysqli_num_rows($result_details_bulletin) > 0) {
            $row_details_bulletin = mysqli_fetch_assoc($result_details_bulletin);

            $employe_id = $row_details_bulletin['idEmploye'];
            $sql_employe_info = "SELECT * FROM employe WHERE Id = $employe_id";
            $result_employe_info = mysqli_query($conn, $sql_employe_info);
            $row_employe_info = mysqli_fetch_assoc($result_employe_info);

            $logo_path = 'chemin/vers/votre/logo.png';
            $pdf->Image($logo_path, 10, 10, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

            $pdf->SetFont('helvetica', '', 10);
            $pdf->SetXY(50, 10);
            $pdf->Cell(0, 10, 'ISGA RABAT', 0, false, 'L', 0, '', 0, false, 'T', 'M');
            $pdf->SetXY(50, 15);
            $pdf->Cell(0, 10, '27 Avenue Oqba', 0, false, 'L', 0, '', 0, false, 'T', 'M');
            $pdf->SetXY(50, 20);
            $pdf->Cell(0, 10, 'Rabat, 10000', 0, false, 'L', 0, '', 0, false, 'T', 'M');
            $pdf->SetXY(50, 25);
            $pdf->Cell(0, 10, 'Téléphone: +212 05377-71468', 0, false, 'L', 0, '', 0, false, 'T', 'M');
            $pdf->SetXY(50, 30);
            $pdf->Cell(0, 10, 'E-mail: info@isga.ma', 0, false, 'L', 0, '', 0, false, 'T', 'M');

            $pdf->Rect(140, 10, 60, 50);
            $pdf->SetFont('helvetica', '', 10);
            $pdf->SetXY(145, 15);
            $pdf->Cell(0, 10, 'Informations de l\'employé', 0, false, 'C', 0, '', 0, false, 'T', 'M');
            $pdf->SetXY(145, 25);
            $pdf->Cell(0, 10, 'Nom: ' . $row_employe_info['Nom'] . ' ' . $row_employe_info['Prenom'], 0, false, 'L', 0, '', 0, false, 'T', 'M');
            $pdf->SetXY(145, 35);
            $pdf->Cell(0, 10, 'Matricule: ' . $row_employe_info['Matricule'], 0, false, 'L', 0, '', 0, false, 'T', 'M');
            $pdf->SetXY(145, 45);
            $pdf->Cell(0, 10, 'Code CNSS: ' . $row_employe_info['CodeCNSS'], 0, false, 'L', 0, '', 0, false, 'T', 'M');

            $pdf->Ln(20);

            $pdf->SetFillColor(200, 220, 255);
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell(190, 10, 'Détails du Bulletin de Paie', 0, 1, 'C', 1);
            $pdf->SetFont('helvetica', '', 10);
            foreach ($row_details_bulletin as $key => $value) {
                $pdf->Cell(95, 10, $key, 1, 0, 'L', 1);
                $pdf->Cell(95, 10, $value, 1, 1, 'L', 1);
            }

            $pdf->Ln(10);

            if (isset($row_employe_info['Nom']) && isset($row_employe_info['Prenom'])) {
                $filename = 'Bulletin_' . $row_employe_info['Nom'] . '_' . $row_employe_info['Prenom'] . '_' . date('Y-m-d') . '.pdf';
            } else {
                $filename = 'Bulletin_de_Paie.pdf';
            }

            $pdf->Output($filename, 'D');
        } else {
            $pdf->Cell(0, 10, 'Bulletin de paie non trouvé.', 0, false, 'C', 0, '', 0, false, 'T', 'M');
        }
    } else {
        $pdf->Cell(0, 10, 'ID du bulletin non spécifié.', 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Bulletin de Paie</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include_once 'navbar.php'; ?>
        <?php include_once 'sidebar.php'; ?>
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Détails du Bulletin de Paie</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <?php
                                                if (isset($_GET['id'])) {
                                                    $bulletin_id = $_GET['id'];

                                                    $sql_details_bulletin = "SELECT * FROM bulletinpaie WHERE idBulletin = $bulletin_id";
                                                    $result_details_bulletin = mysqli_query($conn, $sql_details_bulletin);

                                                    if ($result_details_bulletin && mysqli_num_rows($result_details_bulletin) > 0) {
                                                        $row_details_bulletin = mysqli_fetch_assoc($result_details_bulletin);

                                                        $details_with_netpay = array();
                                                        $net_pay_key = '';
                                                        foreach ($row_details_bulletin as $key => $value) {
                                                            if ($key != 'NetAPayer') {
                                                                $details_with_netpay[$key] = $value;
                                                            } else {
                                                                $net_pay_key = $key;
                                                            }
                                                        }

                                                        foreach ($details_with_netpay as $key => $value) {
                                                            echo "<tr>";
                                                            echo "<td><strong>$key</strong></td>";
                                                            echo "<td>$value</td>";
                                                            echo "</tr>";
                                                        }

                                                        if (!empty($net_pay_key)) {
                                                            echo "<tr>";
                                                            echo "<td><strong>$net_pay_key</strong></td>";
                                                            echo "<td>{$row_details_bulletin[$net_pay_key]}</td>";
                                                            echo "</tr>";
                                                        }
                                                    } else {
                                                        echo "<tr><td colspan='2'>Bulletin de paie non trouvé.</td></tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='2'>ID du bulletin non spécifié.</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <form method="post" action="">
                                        <button type="submit" class="btn btn-primary" name="generate_pdf">Générer
                                            PDF</button>
                                    </form>
                                    <?php
                                    if (isset($_POST['generate_pdf'])) {
                                        generatePDF();
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include_once 'footer.php'; ?>
    </div>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>
</body>

</html>