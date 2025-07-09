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
        
        .header_section_sticky th{
            background-color: #ffffff;
        }
        .text_area_heading{
            /*text-align: center;*/
            font-size: 20px;
        }
        
    </style>
</head>
<body>
<table class="table table-striped datatable table-hover dataTable no-footer">
    <thead>
        
        <tr class="header_section_sticky">
            <th colspan="10">
                <img style="width: 100%;" src="https://attc.aqato.com.au/public/assets/image/header_logo.jpg">
            </th>
        </tr>
        <tr class="header_section_sticky">
            <th colspan="10">
                <div class="text_area_heading">
                    Reporting
                </div>
                
                <div class="text_area_para">
                    %date_filter%
                </div>
                
                
            </th>
        </tr>
        <tr>
            <th style="width: 5%;"><b>Sr.No.</b></th>
            <th style="width: 5%;">
                <span data-bs-toggle="tooltip" data-bs-placement="top" title="Portal Reference No.">
                    PRN
                </span>
            </th>
            <th style="width: 10%;">Applicant No.</th>
            <th style="width: 25%;">Applicant Name </th>
            <th style="width: 10%;">D.O.B </th>
            <th style="width: 15%;">Occupation</th>
            <th style="width: 10%;">Pathway</th>
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