<!DOCTYPE html>
<html>

<head>
    <title>Application Sheet</title>
    <style>
        @page {
            margin: 0.5cm;
        }

        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Inter', Arial, sans-serif;
            font-size: 12px;
            color: #333;
            position: relative;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header .program-name {
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }

        .header .document-title {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }

        .header-table,
        .application-table,
        .recommendations-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 0 15px 0;
        }

        .header-table th {
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            padding: 10px;
            font-size: 14px;
            font-weight: 600;
            color: #333;
            text-align: center;
        }

        .application-table th,
        .application-table td,
        .recommendations-table th,
        .recommendations-table td {
            border: 1px solid #ccc;
            padding: 8px 12px;
        }

        .application-table th,
        .recommendations-table th {
            background-color: #f0f0f0;
            font-weight: 500;
            color: #333;
        }

        .application-table td,
        .recommendations-table td {
            font-size: 12px;
            color: #333;
        }

        .recommendations-header-table th {
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            padding: 6px;
            font-size: 12px;
            font-weight: 600;
            color: #333;
            text-align: left;
        }

        .container {
            display: flex;
            justify-content: space-between;
        }

        .left-section {
            width: 48%;
        }

        .right-section {
            width: 48%;
        }

        .equipment-section {
            padding: 10px;
            border: 1px solid #ccc;
        }

        .operator-section {
            padding: 10px;
            border: 1px solid #ccc;
            margin-top: 10px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #666;
            padding-top: 10px;
            padding-bottom: 10px;
            background-color: #f0f0f0;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <div class="document-title">Application Sheet</div>
    </div>

    <!-- Programs Section -->
    @php
    $blocksGrouped = $programs->groupBy('crop.block_number');
    $groupCounter = 0;
    @endphp

    @foreach($blocksGrouped as $blockNumber => $blockPrograms)
    <table class="header-table">
        <tr>
            <th colspan="7">Application Sheet for Crop: {{ $blockNumber }}</th>
        </tr>
    </table>
    <table class="application-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Block</th>
                <th>Time</th>
                <th>Tractor Start Hours</th>
                <th>Tractor End Hours</th>
                <th>Tank Number</th>
                <th>Liters Applied</th>
            </tr>
        </thead>
        <tbody>
            @foreach($blockPrograms as $program)
            @foreach($program->agrochemicalProgramApplications as $application)
            <tr>
                <td>{{ $application->application_date ?? ' ' }}</td>
                <td>{{ $blockNumber }}</td>
                <td>{{ $application->time ?? ' ' }}</td>
                <td>{{ $application->tractor_start_hours ?? ' ' }}</td>
                <td>{{ $application->tractor_end_hours ?? ' ' }}</td>
                <td>{{ $application->tank_number ?? ' ' }}</td>
                <td>{{ $application->liters_applied ?? ' ' }}</td>
            </tr>
            @endforeach
            @endforeach
        </tbody>
    </table>

    @php $groupCounter++; @endphp
    @if($groupCounter % 2 == 0)
    <div class="page-break"></div>
    @endif
    @endforeach

    <!-- Two-Column Container -->
    <div class="container">
        <!-- Left Section -->
        <div class="left-section">

        </div>

        <!-- Right Section -->
        <div class="right-section">
            <table class="header-table">
                <tr>
                    <th colspan="3">Recommendations per 1500 L Tank</th>
                </tr>
            </table>
            <table class="recommendations-table">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Agrochemical Name</th>
                        <th>Recommended Dosage</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $sortedPrograms = $programs->sortBy(function ($program) {
                    return $program->agrochemical->mixing_order ?? PHP_INT_MAX;
                    });
                    $displayedAgrochemicals = [];
                    @endphp
                    @foreach($sortedPrograms as $program)
                    @if(!in_array($program->agrochemical->id, $displayedAgrochemicals))
                    <tr>
                        <td>{{ $program->agrochemical->mixing_order ?? 'N/A' }}</td>
                        <td>{{ $program->agrochemical->name ?? 'N/A' }}</td>
                        <td>{{ $program->agrochemical->recommended_dosage ?? 'N/A' }} L</td>
                    </tr>
                    @php
                    $displayedAgrochemicals[] = $program->agrochemical->id;
                    @endphp
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>