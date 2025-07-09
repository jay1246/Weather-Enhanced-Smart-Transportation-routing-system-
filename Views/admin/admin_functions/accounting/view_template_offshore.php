<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offshores Fees</title>
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
        td{
            padding-left: 12px;
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
            <th colspan="10" style="text-align: center;">
                <img style="width: 30%; margin: 0 auto; display: block;" src="https://attc.aqato.com.au/public/Logos/Aqato_logo.png">
            </th>
        </tr>
        <tr class="header_section_sticky">
            <th colspan="10">
                <div class="text_area_heading">
                    Offshore Interviews Sheet
                </div>
                
                <div class="text_area_para">
                    %date_filter%
                </div>
                
                
            </th>
        </tr>
        <tr>
            <th style="width: 5%; text-align: left;"><b>Sr.No.</b></th>
            <th style="width: 10%; text-align: left;"><b>Applicant No.</b></th>
            <th style="width: 20%; text-align: left;"><b>Applicant Name </b></th>
            <th style="width: 10%; text-align: left;"><b>D.O.B </b></th>
            <th style="width: 10%; text-align: left;"><b>Occupation</b></th>
            <th style="text-align: left;"><b>Pathway</b></th>
            <th style="width: 15%; text-align: left;"><b>Interview Location</b></th> 
            <th style="width: 10%; text-align: left;"><b>Interview Date</b></th> 
            <th style="width: 10%; text-align: left;"><b>Amount (AUD)</b></th>
            <!-- Add more columns headers as needed -->
        </tr>
    </thead>
    %tbody%
</table>
</body>
</html>