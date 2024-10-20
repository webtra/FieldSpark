<!DOCTYPE html>
<html>

<head>
    <title>Cultivars PDF</title>
    <style>
        /* Import the Inter font */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap');

        /* Apply font globally */
        body {
            font-family: 'Inter', sans-serif;
            /* Standard 1-inch margin */
            text-align: center;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
        }

        /* Centering the table */
        .container {
            margin: 0 auto;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
            /* Center table horizontally */
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 10px;
        }

        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        thead {
            display: table-header-group;
            /* Repeat table headers on each page */
        }

        tbody {
            display: table-row-group;
        }

        /* Prevent page breaks inside rows */
        tr {
            page-break-inside: avoid;
        }

        /* Footer with page number */
        @page {
            margin: 1in;

            @bottom-right {
                content: "Page " counter(page) " of " counter(pages);
                font-size: 10px;
                font-family: 'Inter', sans-serif;
            }
        }
    </style>
</head>

<body>
    <!-- Header should appear at the top of the first page -->
    <h1>Cultivars List</h1>

    <!-- Table should start immediately after the header -->
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Variety Number</th>
                    <th>Prime Name</th>
                    <th>Country</th>
                    <th>Color of Berry Skin</th>
                    <th>Country of Origin</th>
                    <th>Species</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cultivars as $cultivar)
                <tr>
                    <td>{{ $cultivar->variety_number }}</td>
                    <td>{{ $cultivar->prime_name }}</td>
                    <td>{{ $cultivar->country }}</td>
                    <td>{{ $cultivar->color_of_berry_skin }}</td>
                    <td>{{ $cultivar->country_of_origin }}</td>
                    <td>{{ $cultivar->species }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>