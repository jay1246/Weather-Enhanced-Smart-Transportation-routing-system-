<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporting</title>
    <style>
        *{
            margin: 0px;
            padding: 5px;
            font-size: 12px;
        }
        table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        }

        td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
        }
        th{
            background-color: #dddddd;    
        }

    </style>
</head>
<body>
    
<table class="table table-striped datatable table-hover dataTable no-footer">
    <thead>
        <tr>
            <th style="width: 5%;">
                <span data-bs-toggle="tooltip" data-bs-placement="top" title="Portal Reference No.">
                    PRN
                </span>
            </th>
            <th style="width: 10%;">Applicant No.</th>
            <th style="width: 30%;">Applicant Name </th>
            <th style="width: 10%;">D.O.B </th>
            <th style="width: 15%;">Occupation</th>
            <th style="width: 15%;">Date %__date_stage__%</th>
            <th style="width: 15%;">Current Status</th>
            %__agent_name__%
        </tr>
    </thead>
    <tbody>
        %tbody%
    </tbody>
</table>
</body>
</html>