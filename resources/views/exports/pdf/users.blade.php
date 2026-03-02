<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>
        @page {
            margin: 120px 40px 80px 40px;
        }

        body {
            font-family: sans-serif;
            font-size: 11px;
            color: #1f2937;
        }

        header {
            position: fixed;
            top: -100px;
            left: 0;
            right: 0;
            height: 80px;
            border-bottom: 2px solid #1e3a8a;
            padding-bottom: 10px;
        }

        .header-container {
            width: 100%;
        }

        .institution-name {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            color: #1e3a8a;
            text-transform: uppercase;
        }

        .report-title {
            font-size: 13px;
            margin-top: 4px;
            color: #374151;
        }

        .report-meta {
            font-size: 10px;
            color: #6b7280;
            margin-top: 4px;
        }

        footer {
            position: fixed;
            bottom: -60px;
            left: 0;
            right: 0;
            height: 40px;
            border-top: 1px solid #9ca3af;
            font-size: 10px;
            color: #4b5563;
            text-align: center;
            line-height: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        thead {
            background-color: #1e3a8a;
            color: #ffffff;
        }

        th {
            padding: 8px;
            text-align: left;
            font-size: 11px;
            font-weight: bold;
        }

        td {
            padding: 7px;
            border-bottom: 1px solid #e5e7eb;
        }

        tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .summary {
            margin-top: 15px;
            font-size: 11px;
            color: #374151;
        }
    </style>
</head>

<body>

<header>
    <div class="header-container">
        <div class="institution-name">
            {{ config('app.name') }}
        </div>

        <div class="report-title">
            Reporte Oficial de Usuarios Registrados
        </div>

        <div class="report-meta">
            Fecha de emisión: {{ now()->format('d/m/Y H:i') }}
        </div>
    </div>
</header>

<footer>
    Página {PAGENO} de {nb}
</footer>

<main>
    <table>
        <thead>
            <tr>
                <th width="10%">#</th>
                <th width="35%">Nombre</th>
                <th width="55%">Correo Electrónico</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $index => $user)
                <tr>
                    <td>
                        {{ $index + 1 }}
                    </td>
                    <td>
                        {{ $user->name }}
                    </td>
                    <td>
                        {{ $user->email }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        Total de registros: {{ count($users) }}
    </div>
</main>

</body>
</html>
