<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Passerelle API Cristalline</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #0b0e14;
            color: #e6edf3;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: #161b22;
            padding: 30px;
            border-radius: 12px;
            border: 1px solid #30363d;
        }

        h1 {
            color: #58a6ff;
            border-bottom: 1px solid #30363d;
            padding-bottom: 10px;
        }

        .status {
            color: #3fb950;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #30363d;
            text-align: left;
        }

        th {
            background: #0d1117;
        }

        .badge {
            background: #21262d;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.8em;
            color: #ff7b72;
        }
    </style>
</head>

<body>
    <div class="container">
    <h1>🛡️ Passerelle API & Accès BDD</h1>
    
    <div style="background: #1c2128; border-left: 4px solid #3fb950; padding: 15px; margin-bottom: 20px;">
        <p style="margin: 0; font-size: 0.9em;">
            <strong>Contrôle d'accès :</strong> 
            <span class="status">Mode Restreint Activé</span><br>
            <span style="color: #8b949e;">Seuls les terminaux avec <code>Bearer Token</code> sont autorisés à modifier la BDD.</span>
        </p>
    </div>

    <p>Statut de la liaison : <span class="status">Alwaysdata Connecté</span></p>

    <table>
        ...
    </table>
</div>
</body>

</html>