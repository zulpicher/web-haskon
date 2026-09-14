<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #222;
        }

        h2 {
            text-align: center;
            margin-bottom: 0;
        }

        .period {
            text-align: center;
            margin-bottom: 16px;
        }

        .opening {
            margin-bottom: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px 8px;
            text-align: left;
        }

        th {
            background: #f3f4f6;
        }

        .text-right {
            text-align: right;
        }

        .totals {
            margin-top: 16px;
        }

        .totals div {
            margin-bottom: 4px;
        }

        .warning {
            background: #fee2e2;
            color: #991b1b;
            padding: 8px;
            margin-bottom: 12px;
            border: 1px solid #fca5a5;
        }
    </style>
</head>

<body>

    <h2>LAPORAN BUKU KAS</h2>

    <div class="period">
        Periode
        {{ $report['start_date']->format('d/m/Y') }}
        s/d
        {{ $report['end_date']->format('d/m/Y') }}
    </div>


    {{-- Peringatan saldo negatif --}}
    @if ($report['is_negative'])

        <div class="warning">
            PERHATIAN: Saldo akhir periode berada di bawah nol.
        </div>

    @endif


    {{-- Saldo awal --}}
    <div class="opening">
        Saldo per tanggal
        {{ $report['start_date']->copy()->subDay()->format('d/m/Y') }}:

        <strong>
            Rp{{ number_format($report['opening_balance'], 0, ',', '.') }}
        </strong>
    </div>


    {{-- Tabel transaksi --}}
    <table>

        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th class="text-right">Kas Masuk</th>
                <th class="text-right">Kas Keluar</th>
                <th class="text-right">Saldo</th>
            </tr>
        </thead>

        <tbody>

            @forelse ($report['rows'] as $row)

                <tr>

                    <td>
                        {{ $row['date']->format('d/m/Y') }}
                    </td>

                    <td>
                        {{ $row['description'] }}
                    </td>

                    <td class="text-right">
                        @if ($row['income'] !== null)
                            Rp{{ number_format($row['income'], 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>

                    <td class="text-right">
                        @if ($row['expense'] !== null)
                            Rp{{ number_format($row['expense'], 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>

                    <td class="text-right">
                        Rp{{ number_format($row['balance'], 0, ',', '.') }}
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="5" style="text-align: center;">
                        Tidak ada transaksi pada periode ini.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>


    {{-- Total --}}
    <div class="totals">

        <div>
            Total Kas Masuk:
            <strong>
                Rp{{ number_format($report['total_income'], 0, ',', '.') }}
            </strong>
        </div>

        <div>
            Total Kas Keluar:
            <strong>
                Rp{{ number_format($report['total_expense'], 0, ',', '.') }}
            </strong>
        </div>

        <div>
            <strong>
                Saldo per tanggal
                {{ $report['end_date']->format('d/m/Y') }}:

                Rp{{ number_format($report['closing_balance'], 0, ',', '.') }}
            </strong>
        </div>

    </div>

</body>
</html>
