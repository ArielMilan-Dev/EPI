<?php
$initials  = strtoupper(substr($student['first_name'] ?? 'E', 0, 1) . substr($student['last_name'] ?? 'P', 0, 1));
$fullName  = htmlspecialchars(($student['first_name'] ?? '') . ' ' . ($student['last_name'] ?? ''));
$joinDate  = !empty($student['created_at']) ? (new DateTime($student['created_at']))->format('d/m/Y') : '—';
$birthDate = !empty($student['birth_date']) ? (new DateTime($student['birth_date']))->format('d/m/Y') : '—';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fiche Étudiant - <?= $fullName ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1a2b4a;
            --accent: #f0a500;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            color: #333;
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        .page-container {
            max-width: 800px;
            margin: 40px auto;
            background: #fff;
            padding: 60px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-top: 10px solid var(--primary);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #eee;
            padding-bottom: 30px;
            margin-bottom: 40px;
        }
        .logo-box {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .logo-icon {
            width: 50px;
            height: 50px;
            background: var(--accent);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
            border-radius: 8px;
        }
        .school-name {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary);
            margin: 0;
        }
        .school-sub {
            color: #666;
            font-size: 14px;
            margin: 5px 0 0 0;
        }
        .doc-title {
            text-align: right;
        }
        .doc-title h2 {
            margin: 0;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .doc-title p {
            margin: 5px 0 0 0;
            color: #666;
        }
        
        .student-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 40px;
            background: #f8fafc;
            padding: 20px;
            border-radius: 12px;
            border-left: 4px solid var(--accent);
        }
        .student-avatar {
            width: 80px;
            height: 80px;
            background: var(--primary);
            color: #fff;
            font-size: 32px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
        .student-name {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 5px 0;
        }
        .student-id {
            font-family: monospace;
            font-size: 16px;
            color: var(--primary);
            background: rgba(240, 165, 0, 0.2);
            padding: 4px 10px;
            border-radius: 4px;
            font-weight: 600;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }
        .info-group {
            margin-bottom: 20px;
        }
        .info-label {
            font-size: 12px;
            text-transform: uppercase;
            color: #888;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
            display: block;
            font-weight: 600;
        }
        .info-value {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        
        .footer {
            margin-top: 60px;
            text-align: center;
            color: #888;
            font-size: 12px;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        
        @media print {
            body { background: #fff; }
            .page-container {
                box-shadow: none;
                margin: 0;
                padding: 0;
                border-top: none;
            }
            .no-print { display: none; }
        }
        
        .print-btn {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 15px;
            background: var(--primary);
            color: #fff;
            text-align: center;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            border: none;
        }
    </style>
</head>
<body onload="window.print()">

    <button onclick="window.print()" class="print-btn no-print">Imprimer / Sauvegarder en PDF</button>

    <div class="page-container">
        <div class="header">
            <div class="logo-box">
                <div class="logo-icon">E</div>
                <div>
                    <h1 class="school-name">EPI</h1>
                    <p class="school-sub">École Polytechnique de Yamoussoukro</p>
                </div>
            </div>
            <div class="doc-title">
                <h2>Fiche Étudiant</h2>
                <p>Générée le <?= date('d/m/Y') ?></p>
            </div>
        </div>

        <div class="student-header">
            <div class="student-avatar"><?= $initials ?></div>
            <div>
                <h2 class="student-name"><?= $fullName ?></h2>
                <span class="student-id"><?= htmlspecialchars($student['student_id'] ?? '—') ?></span>
            </div>
        </div>

        <div class="info-grid">
            <div>
                <h3 style="color: var(--primary); margin-bottom: 20px; border-bottom: 2px solid var(--accent); padding-bottom: 5px; display: inline-block;">Informations Personnelles</h3>
                
                <div class="info-group">
                    <span class="info-label">Prénom</span>
                    <div class="info-value"><?= htmlspecialchars($student['first_name'] ?? '—') ?></div>
                </div>
                <div class="info-group">
                    <span class="info-label">Nom</span>
                    <div class="info-value"><?= htmlspecialchars($student['last_name'] ?? '—') ?></div>
                </div>
                <div class="info-group">
                    <span class="info-label">Date de naissance</span>
                    <div class="info-value"><?= $birthDate ?></div>
                </div>
                <div class="info-group">
                    <span class="info-label">Téléphone</span>
                    <div class="info-value"><?= htmlspecialchars($student['phone'] ?? '—') ?></div>
                </div>
                <div class="info-group">
                    <span class="info-label">Email</span>
                    <div class="info-value"><?= htmlspecialchars($student['email'] ?? '—') ?></div>
                </div>
            </div>

            <div>
                <h3 style="color: var(--primary); margin-bottom: 20px; border-bottom: 2px solid var(--accent); padding-bottom: 5px; display: inline-block;">Informations Académiques</h3>
                
                <div class="info-group">
                    <span class="info-label">Identifiant EPI</span>
                    <div class="info-value" style="font-family: monospace;"><?= htmlspecialchars($student['student_id'] ?? '—') ?></div>
                </div>
                <div class="info-group">
                    <span class="info-label">Filière / Classe</span>
                    <div class="info-value"><?= htmlspecialchars($student['class_name'] ?? '—') ?></div>
                </div>
                <div class="info-group">
                    <span class="info-label">Date d'inscription</span>
                    <div class="info-value"><?= $joinDate ?></div>
                </div>
            </div>
        </div>

        <div class="footer">
            Document officiel généré par le système d'administration de l'EPI Yamoussoukro.<br>
            Toute falsification de cette fiche est passible de sanctions disciplinaires.
        </div>
    </div>

</body>
</html>
