<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Performance Evaluation - Office Staff</title>
    <style>
        /* ===== PRINT MODE ===== */
        @media print {
            /* All text fields and textarea should look like plain text */
            input, textarea, select {
                border: none !important;
                outline: none !important;
                background: transparent !important;
                color: #000 !important;
                font-size: 16px !important;
                width: auto !important;
                pointer-events: none; /* makes them uneditable */
            }

            /* Hide the placeholder text (if any) */
            input::placeholder, textarea::placeholder {
                color: transparent !important;
            }

            /* Hide radio buttons and checkboxes */
            input[type="radio"], input[type="checkbox"] {
                visibility: hidden;
                position: relative;
            }

            /* Show the selected radio value next to its label */
            input[type="radio"]:checked + label::after {
                content: " ✔";
                font-weight: bold;
                color: #000;
            }

            /* Hide buttons (if any exist) */
            button, input[type="button"], input[type="submit"] {
                display: none !important;
            }
        }

        /* Body and Page Layout */
        body {
            font-family: "Times New Roman", serif;
            margin: 20px auto;
            background: #fff;
            color: #000;
            width: 75%;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            border: 2px solid black;
            padding: 20px;
            box-sizing: border-box;
        }

        form {
            border: 2px solid black;
            padding: 20px;
            border-radius: 6px;
            box-sizing: border-box;
        }

        /* Page content box */
        .page {
            display: block;
            border: 1px solid #000;
            padding: 20px;
            margin-bottom: 20px;
            flex: 1;
        }

        /* Headings */
        h2 {
            text-align: center;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        /* Header box */
        .header {
            border: 1px solid #000;
            padding: 10px;
            margin-bottom: 10px;
            position: relative;
        }

        .header label {
            font-weight: bold;
        }

        .header input[type="text"], 
        .header input[type="date"] {
            width: 200px;
        }

        /* Key section */
        .key {
            border: 1px solid #000;
            padding: 5px;
            margin-bottom: 10px;
            font-size: 14px;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            border: 2px solid #000;
        }

        /* Apply vertical borders */
        table th, table td {
            border-left: 1px solid #000;
            border-right: 1px solid #000;
            padding: 5px;
            font-size: 14px;
            vertical-align: top;
        }

        /* Top border for first row */
        table tr:first-child th {
            border-top: 1px solid #000;
        }

        /* Bottom border for last row */
        table tr:last-child td {
            border-bottom: 1px solid #000;
        }

        /* Remove other horizontal borders */
        table td, table th {
            border-top: none;
            border-bottom: none;
        }

        /* Ratings + Text Layout */
        .task {
            width: 70%;
            padding-right: 10px;
            border-right: 1px solid #000;
        }

        .rating {
            width: 30%;
            text-align: center;
            white-space: nowrap;
        }

        /* Reviewer options */
        .reviewer-options label {
            margin-left: 15px;
        }

        /* Sub-points */
        .sub-points {
            margin-left: 20px;
        }

        /* Lines */
        .lines {
            border-bottom: 1px solid #000;
            display: block;
            width: 100%;
            margin: 5px 0;
        }

        /* Footer */
        .footer-section {
            margin-top: 20px;
        }

        .footer-section label {
            font-weight: bold;
        }

        .footer-input {
            display: inline-block;
            width: 250px;
            border-bottom: 1px solid #000;
            margin-left: 5px;
        }

        /* Navigation buttons */
        .nav-buttons {
            text-align: center;
            margin-top: 20px;
        }

        .nav-buttons button {
            padding: 8px 18px;
            font-size: 14px;
            border: 1px solid #000;
            background: #f4f4f4;
            cursor: pointer;
            margin: 0 10px;
            border-radius: 4px;
        }

        .nav-buttons button:hover {
            background: #ddd;
        }

        /* Print button */
        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            font-size: 14px;
            font-family: 'Poppins-Regular', sans-serif;
            background: #17a2b8;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            z-index: 1000;
            transition: all 0.3s;
        }

        .print-btn:hover {
            background-color: #fff;
            color: #000;
            border: 1px solid #000;
        }

        /* Save button */
        .save-btn {
            position: fixed;
            top: 60px;
            right: 20px;
            padding: 10px 20px;
            font-size: 14px;
            font-family: 'Poppins-Regular', sans-serif;
            background: #17a2b8;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            z-index: 1000;
            transition: all 0.3s;
        }

        .save-btn:hover {
            background-color: #fff;
            color: #000;
            border: 1px solid #000;
        }

        /* View Saved button */
        .view-saved-btn {
            position: fixed;
            top: 100px;
            right: 20px;
            padding: 10px 20px;
            font-size: 14px;
            font-family: 'Poppins-Regular', sans-serif;
            background: #616161;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            z-index: 1000;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }

        .view-saved-btn:hover {
            background-color: #000000;
            color: white;
            text-decoration: none;
        }

        td.text-col {
            padding-left: 20px;
            padding-right: 10px;
        }
        
        td.rating-col {
            text-align: center;
            white-space: nowrap;
        }

        /* Subheading style */
        .subheading {
            font-weight: bold;
            font-style: italic;
            padding-left: 15px;
            background: #fafafa;
        }

        /* Subpoints style */
        .subpoint {
            padding-left: 35px;
        }

        /* Print styles */
        @media print {
            body {
                width: 100%;
                border: none;
                padding: 0;
                margin: 0;
            }

            .page {
                page-break-after: always;
                padding: 10px !important;
                margin-bottom: 0 !important;
            }

            .page:last-of-type {
                page-break-after: auto;
            }

            .nav-buttons, button {
                display: none;
            }

            /* Hide the print button in print mode */
            .print-btn {
                display: none !important;
            }

            /* Hide the save button in print mode */
            .save-btn {
                display: none !important;
            }

            /* Hide the view saved button in print mode */
            .view-saved-btn {
                display: none !important;
            }

            /* Ensure tables don't break across pages */
            table {
                page-break-inside: avoid;
                break-inside: avoid;
                margin-bottom: 8px !important;
            }

            /* Ensure sections don't break awkwardly */
            .header, .key, .footer-section {
                page-break-inside: avoid;
                break-inside: avoid;
            }

            /* Adjust spacing for print */
            h2 {
                margin-top: 0;
                margin-bottom: 10px !important;
                font-size: 18px !important;
            }

            /* Compact header and key sections */
            .header {
                padding: 7px !important;
                margin-bottom: 7px !important;
                font-size: 12px !important;
            }

            .key {
                padding: 5px !important;
                margin-bottom: 7px !important;
                font-size: 12px !important;
            }

            /* Make table cells more compact */
            table th, table td {
                padding: 4px 6px !important;
                font-size: 12px !important;
                line-height: 1.35 !important;
            }
            
            /* Even more compact for rating column */
            .rating-col {
                padding: 3px 4px !important;
                font-size: 11px !important;
            }
            
            .text-col {
                padding-left: 14px !important;
                padding-right: 10px !important;
                padding-top: 3px !important;
                padding-bottom: 3px !important;
            }

            .subheading {
                padding-left: 12px !important;
                padding-top: 2px !important;
                padding-bottom: 2px !important;
            }

            .subpoint {
                padding-left: 28px !important;
                padding-top: 2px !important;
                padding-bottom: 2px !important;
            }


            /* Reduce paragraph spacing */
            p {
                margin: 6px 0 4px 0 !important;
                font-size: 12px !important;
            }

            /* Make textareas more compact */
            textarea {
                line-height: 18px !important;
                font-size: 12px !important;
                min-height: 18px !important;
                max-height: 36px !important;
            }
            
            /* Make sub-points list more compact */
            .sub-points {
                margin: 2px 0 !important;
                padding-left: 22px !important;
                font-size: 11.5px !important;
            }
            
            .sub-points li {
                margin: 1px 0 !important;
                padding: 0 !important;
                line-height: 1.3 !important;
            }

            /* Compact footer section */
            .footer-section {
                margin-top: 12px !important;
                font-size: 12px !important;
            }

            .footer-section > div {
                margin-bottom: 10px !important;
            }

            .footer-section label {
                font-size: 12px !important;
            }

            .footer-section input[type="text"] {
                font-size: 12px !important;
                line-height: 18px !important;
            }

            /* Reduce top bar spacing */
            div[style*="border-bottom:5px solid"] {
                margin-bottom: 8px !important;
                padding-bottom: 3px !important;
                font-size: 14px !important;
            }

            /* Bottom copyright line spacing */
            .footer-section > div[style*="border-top"] {
                margin-top: 18px !important;
                padding-top: 5px !important;
                font-size: 12px !important;
            }

            /* ✅ KEEP RADIO AND CHECKBOXES VISIBLE AND SELECTABLE */
            input[type="radio"],
            input[type="checkbox"] {
                visibility: visible !important;
                appearance: auto !important;
                -webkit-appearance: auto !important;
                transform: scale(1.0); /* standard size for compact layout */
                margin-right: 4px;
            }

            /* ✅ Make text fields readable and uneditable */
            input[type="text"],
            input[type="date"],
            input[type="number"],
            textarea,
            select {
                border: none !important;
                background: transparent !important;
                color: #000 !important;
                pointer-events: none;
                font-size: 13px !important;
                width: auto !important;
            }

            /* Keep radio + label aligned on same line */
            input[type="radio"], input[type="checkbox"], label {
                display: inline-block !important;
                vertical-align: middle !important;
                white-space: nowrap !important;
            }

            /* Make print full-width */
            @page {
                size: A4;
                margin: 10mm;
            }
        }
    </style>
</head>
<body>
    <!-- Print Button -->
    <button class="print-btn" onclick="window.print()">🖨️ Print Form</button>
    
    <!-- Save Button -->
    <button class="save-btn" onclick="saveForm()">💾 Save Form</button>
    
    <!-- View Saved Button -->
    <a href="view_saved_rn_evaluations.php" class="view-saved-btn">📁 View Saved</a>
    
    <!-- Page 1 -->
    <div class="page">
        <!-- Top Bar -->
        <div style="text-align:right; font-weight:bold; border-bottom:5px solid #000; margin-bottom:10px; padding-bottom:3px;">
            Job Descriptions
        </div>

        <h2>PERFORMANCE EVALUATION</h2>

        <!-- Header -->
        <div class="header" style="position:relative;">
            <label style="font-weight:bold;">Job Title/Position:</label> <i>Office Staff</i> <br><br>

            <label style="font-weight:bold;">Date:</label> 
            <input type="date" name="review_date"> 
            <br><br>

            <label style="font-weight:bold;">Reviewer:</label> 
            <input type="text" name="reviewer_name" style="width:200px; margin-right:20px;"> 

            <span class="reviewer-options">
                <label><input type="checkbox" name="reviewer" value="Annual"> Annual</label>
                <label><input type="checkbox" name="reviewer" value="90 Day"> 90 Day</label>
                <label><input type="checkbox" name="reviewer" value="Other"> Other</label>
            </span>

            <!-- Page Number Bottom Right -->
            <span style="position:absolute; right:10px; bottom:5px; font-weight:bold;">Page 1</span>
        </div>

        <!-- Key -->
        <div class="key">
            <b>Key:</b> 4 = Superior Performance &nbsp;&nbsp; 
            3 = Satisfactory Performance &nbsp;&nbsp; 
            2 = Inconsistent Performance &nbsp;&nbsp; 
            1 = Unacceptable Performance
        </div>

        <!-- Responsibilities Table -->
        <table>
            <tr>
                <th style="width:80%; text-align: left;">A. Responsibilities</th>
                <th style="width:20%;">Rating</th>
            </tr>

            <tr>
                <td class="text-col">1. Answering calls from referral sources, prospective clients and/or family members.</td>
                <td class="rating-col">1 <input type="radio" name="r1"> 2 <input type="radio" name="r1"> 3 <input type="radio" name="r1"> 4 <input type="radio" name="r1"></td>
            </tr>

            <tr>
                <td class="text-col">2. Conduct accurate filing of all clinical records for all patient files.</td>
                <td class="rating-col">1 <input type="radio" name="r2"> 2 <input type="radio" name="r2"> 3 <input type="radio" name="r2"> 4 <input type="radio" name="r2"></td>
            </tr>

            <tr>
                <td class="text-col">3. Keeps all staff files in compliance and updated.</td>
                <td class="rating-col">1 <input type="radio" name="r3"> 2 <input type="radio" name="r3"> 3 <input type="radio" name="r3"> 4 <input type="radio" name="r3"></td>
            </tr>

            <tr>
                <td class="text-col">4. Mail and track Treatment Plans, MD and Start of Care Orders.</td>
                <td class="rating-col">1 <input type="radio" name="r4"> 2 <input type="radio" name="r4"> 3 <input type="radio" name="r4"> 4 <input type="radio" name="r4"></td>
            </tr>

            <tr>
                <td class="text-col">5. Coordinates care with clinical field staff.</td>
                <td class="rating-col">1 <input type="radio" name="r5"> 2 <input type="radio" name="r5"> 3 <input type="radio" name="r5"> 4 <input type="radio" name="r5"></td>
            </tr>

            <tr>
                <td class="text-col">6. Intake.</td>
                <td class="rating-col">1 <input type="radio" name="r6"> 2 <input type="radio" name="r6"> 3 <input type="radio" name="r6"> 4 <input type="radio" name="r6"></td>
            </tr>

            <tr>
                <td class="text-col">7. Receives updated orders from physicians.</td>
                <td class="rating-col">1 <input type="radio" name="r7"> 2 <input type="radio" name="r7"> 3 <input type="radio" name="r7"> 4 <input type="radio" name="r7"></td>
            </tr>

            <tr>
                <td class="text-col">8. Performs other duties as assigned by Management.</td>
                <td class="rating-col">1 <input type="radio" name="r8"> 2 <input type="radio" name="r8"> 3 <input type="radio" name="r8"> 4 <input type="radio" name="r8"></td>
            </tr>
        </table>

        <p><b>Targeted Goals For Next Review Cycle:</b></p>
        <textarea rows="5" style="
            width:100%;
            border:none;
            outline:none;
            font-family:'Times New Roman', serif;
            font-size:14px;
            line-height:25px;
            background-image: repeating-linear-gradient(to bottom, white 0px, white 22px, #000 23px);
            background-clip: content-box;
            resize: none;
            margin-bottom:20px;
        "></textarea>

        <p><b>Comments:</b></p>
        <textarea rows="5" style="
            width:100%;
            border:none;
            outline:none;
            font-family:'Times New Roman', serif;
            font-size:14px;
            line-height:25px;
            background-image: repeating-linear-gradient(to bottom, white 0px, white 22px, #000 23px);
            background-clip: content-box;
            resize: none;
            margin-bottom:20px;
        "></textarea>

        <!-- Footer -->
        <div class="footer-section" style="width:100%; margin-top:40px;">
            <!-- Reviewer Row -->
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
                <div style="flex:1;">
                    <label>Reviewer:</label>
                    <input type="text" style="
                        width:82%;
                        border:none;
                        outline:none;
                        font-family:'Times New Roman', serif;
                        font-size:14px;
                        line-height:25px;
                        background-image: repeating-linear-gradient(to bottom, white 0px, white 22px, #000 23px);
                        background-clip: content-box;
                    ">
                </div>
                <div style="text-align:right; white-space:nowrap;">
                    <label>Date:</label>
                    <input type="date">
                </div>
            </div>

            <!-- Name of Personnel Row -->
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
                <div style="flex:1;">
                    <label>Name of Personnel:</label>
                    <input type="text" style="
                        width:76%;
                        border:none;
                        outline:none;
                        font-family:'Times New Roman', serif;
                        font-size:14px;
                        line-height:25px;
                        background-image: repeating-linear-gradient(to bottom, white 0px, white 22px, #000 23px);
                        background-clip: content-box;
                    ">
                </div>
                <div style="text-align:right; white-space:nowrap;">
                    <label>Date:</label>
                    <input type="date">
                </div>
            </div>

            <!-- Bottom Line -->
            <div style="border-top:2px solid #000; margin-top:40px; padding-top:5px;">
            </div>
        </div>
    </div>

    <!-- Page 2 -->
    <div class="page">
        <!-- Top Bar -->
        <div style="text-align:right; font-weight:bold; border-bottom:5px solid #000; margin-bottom:10px; padding-bottom:3px;">
            Job Descriptions
        </div>

        <h2>PERFORMANCE EVALUATION</h2>

        <!-- Header -->
        <div class="header">
            <label style="font-weight:bold;">Job Title/Position:</label> <i>Office Staff</i> <br><br>

            <label style="font-weight:bold;">Date:</label> 
            <input type="date" name="review_date2"> 
            <br><br>

            <label style="font-weight:bold;">Reviewer:</label> 
            <input type="text" name="reviewer_name2" style="width:200px; margin-right:20px;"> 

            <span class="reviewer-options">
                <label><input type="checkbox" name="reviewer2" value="Annual"> Annual</label>
                <label><input type="checkbox" name="reviewer2" value="90 Day"> 90 Day</label>
                <label><input type="checkbox" name="reviewer2" value="Other"> Other</label>
            </span>

            <!-- Page Number Bottom Right -->
            <span style="position:absolute; right:10px; bottom:5px; font-weight:bold;">Page 2</span>
        </div>

        <!-- Key -->
        <div class="key">
            <b>Key:</b> 4 = Superior Performance &nbsp;&nbsp; 
            3 = Satisfactory Performance &nbsp;&nbsp; 
            2 = Inconsistent Performance &nbsp;&nbsp; 
            1 = Unacceptable Performance
        </div>

        <!-- Section B Table -->
        <table>
            <tr>
                <th style="width:80%; text-align: left;">B. Organizational Responsibilities</th>
                <th style="width:20%;">Rating</th>
            </tr>

            <tr>
                <td class="text-col">1. Accepts responsibility for behavior and activity.</td>
                <td class="rating-col">1 <input type="radio" name="org1"> 2 <input type="radio" name="org1"> 3 <input type="radio" name="org1"> 4 <input type="radio" name="org1"></td>
            </tr>
            <tr>
                <td class="text-col">2. Maintains an acceptable work record.<br><br>
                    <input type="text" style="border: none; border-bottom: 1px solid #000; outline: none; width: 80px; background: transparent; text-align: center;"> Days Tardy &nbsp;&nbsp;&nbsp; 
                    <input type="text" style="border: none; border-bottom: 1px solid #000; outline: none; width: 80px; background: transparent; text-align: center;"> Days Absent
                </td>
                <td class="rating-col">1 <input type="radio" name="org2"> 2 <input type="radio" name="org2"> 3 <input type="radio" name="org2"> 4 <input type="radio" name="org2"></td>
            </tr>
            <tr>
                <td class="text-col">3. Is respectful of individual's rights in interacting with patients, families/caregivers and coworkers.</td>
                <td class="rating-col">1 <input type="radio" name="org3"> 2 <input type="radio" name="org3"> 3 <input type="radio" name="org3"> 4 <input type="radio" name="org3"></td>
            </tr>
            <tr>
                <td class="text-col">4. Follows organization guidelines in practice of (a) Infection Control (b) Fire/Safety (c) Patient Care Standards.</td>
                <td class="rating-col">1 <input type="radio" name="org4"> 2 <input type="radio" name="org4"> 3 <input type="radio" name="org4"> 4 <input type="radio" name="org4"></td>
            </tr>
            <tr>
                <td class="text-col">5. Displays appropriate management of equipment and supplies.</td>
                <td class="rating-col">1 <input type="radio" name="org5"> 2 <input type="radio" name="org5"> 3 <input type="radio" name="org5"> 4 <input type="radio" name="org5"></td>
            </tr>
            <tr>
                <td class="text-col">6. Interacts collaboratively with all team members.</td>
                <td class="rating-col">1 <input type="radio" name="org6"> 2 <input type="radio" name="org6"> 3 <input type="radio" name="org6"> 4 <input type="radio" name="org6"></td>
            </tr>
        </table>

        <!-- Targeted Goals and Comments -->
        <p><b>Targeted Goals For Next Review Cycle:</b></p>
        <textarea rows="5" style="
            width:100%;
            border:none;
            outline:none;
            font-family:'Times New Roman', serif;
            font-size:14px;
            line-height:25px;
            background-image: repeating-linear-gradient(to bottom, white 0px, white 22px, #000 23px);
            background-clip: content-box;
            resize: none;
            margin-bottom:20px;
        "></textarea>

        <p><b>Comments:</b></p>
        <textarea rows="5" style="
            width:100%;
            border:none;
            outline:none;
            font-family:'Times New Roman', serif;
            font-size:14px;
            line-height:25px;
            background-image: repeating-linear-gradient(to bottom, white 0px, white 22px, #000 23px);
            background-clip: content-box;
            resize: none;
            margin-bottom:20px;
        "></textarea>

        <!-- Footer -->
        <div class="footer-section" style="width:100%; margin-top:40px;">
            <!-- Reviewer Row -->
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
                <div style="flex:1;">
                    <label>Reviewer:</label>
                    <input type="text" style="
                        width:82%;
                        border:none;
                        outline:none;
                        font-family:'Times New Roman', serif;
                        font-size:14px;
                        line-height:25px;
                        background-image: repeating-linear-gradient(to bottom, white 0px, white 22px, #000 23px);
                        background-clip: content-box;
                    ">
                </div>
                <div style="text-align:right; white-space:nowrap;">
                    <label>Date:</label>
                    <input type="date">
                </div>
            </div>

            <!-- Name of Personnel Row -->
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
                <div style="flex:1;">
                    <label>Name of Personnel:</label>
                    <input type="text" style="
                        width:76%;
                        border:none;
                        outline:none;
                        font-family:'Times New Roman', serif;
                        font-size:14px;
                        line-height:25px;
                        background-image: repeating-linear-gradient(to bottom, white 0px, white 22px, #000 23px);
                        background-clip: content-box;
                    ">
                </div>
                <div style="text-align:right; white-space:nowrap;">
                    <label>Date:</label>
                    <input type="date">
                </div>
            </div>

            <!-- Bottom Line -->
            <div style="border-top:2px solid #000; margin-top:40px; padding-top:5px;">
            </div>
        </div>
    </div>

    <script>
        // Pre-select all radio buttons with rating 4 (Superior Performance)
        window.addEventListener('DOMContentLoaded', function() {
            // Skip auto-selection if this is a saved form
            if (document.body.hasAttribute('data-saved-form')) {
                console.log('Saved form detected - skipping auto-selection');
                return;
            }
            
            // Get all radio buttons
            const allRadios = document.querySelectorAll('input[type="radio"]');
            
            // Group radio buttons by their name attribute
            const radioGroups = {};
            allRadios.forEach(radio => {
                const name = radio.name;
                if (!radioGroups[name]) {
                    radioGroups[name] = [];
                }
                radioGroups[name].push(radio);
            });
            
            // For each group, select the last radio button (which is rating 4)
            Object.keys(radioGroups).forEach(groupName => {
                const radios = radioGroups[groupName];
                if (radios.length > 0) {
                    // Select the last radio button (rating 4)
                    radios[radios.length - 1].checked = true;
                }
            });
        });

        // Save form function
        function saveForm() {
            // Prompt for employee name
            const employeeName = prompt("Enter employee name for this evaluation:");
            if (!employeeName) {
                alert("Employee name is required to save the form.");
                return;
            }

            // Clone the document to modify it without affecting the current page
            const clonedDoc = document.cloneNode(true);
            
            // Add a marker to indicate this is a saved form
            const clonedBody = clonedDoc.querySelector('body');
            if (clonedBody) {
                clonedBody.setAttribute('data-saved-form', 'true');
            }
            
            // Update all text and date inputs with their current values
            const textInputs = document.querySelectorAll('input[type="text"], input[type="date"]');
            const clonedTextInputs = clonedDoc.querySelectorAll('input[type="text"], input[type="date"]');
            textInputs.forEach((input, index) => {
                if (clonedTextInputs[index]) {
                    clonedTextInputs[index].setAttribute('value', input.value);
                }
            });
            
            // Update all checkboxes with their checked state
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            const clonedCheckboxes = clonedDoc.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach((checkbox, index) => {
                if (clonedCheckboxes[index]) {
                    if (checkbox.checked) {
                        clonedCheckboxes[index].setAttribute('checked', 'checked');
                    } else {
                        clonedCheckboxes[index].removeAttribute('checked');
                    }
                }
            });
            
            // Update all radio buttons with their checked state
            const radios = document.querySelectorAll('input[type="radio"]');
            const clonedRadios = clonedDoc.querySelectorAll('input[type="radio"]');
            radios.forEach((radio, index) => {
                if (clonedRadios[index]) {
                    if (radio.checked) {
                        clonedRadios[index].setAttribute('checked', 'checked');
                    } else {
                        clonedRadios[index].removeAttribute('checked');
                    }
                }
            });
            
            // Update all textareas with their current content
            const textareas = document.querySelectorAll('textarea');
            const clonedTextareas = clonedDoc.querySelectorAll('textarea');
            textareas.forEach((textarea, index) => {
                if (clonedTextareas[index]) {
                    clonedTextareas[index].textContent = textarea.value;
                }
            });

            // Get the modified HTML as a string
            const htmlContent = '<!DOCTYPE html>\n' + clonedDoc.documentElement.outerHTML;

            // Send to server
            fetch('save_evaluation.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    employeeName: employeeName,
                    htmlContent: htmlContent,
                    formType: 'OfficeStaff'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(`Form saved successfully!\n\nFile: ${data.filename}\n\nYou can view it later from the saved evaluations list.`);
                } else {
                    alert(`Error saving form: ${data.message}`);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while saving the form.');
            });
        }

        // Detect Ctrl+P or Cmd+P
        document.addEventListener('keydown', function (e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                e.preventDefault(); // Stop the browser's default print
                window.print(); // Trigger print manually
            }
        });

        document.addEventListener("keydown", function(e) {
            // Detect Ctrl + P
            if (e.ctrlKey && e.key === "p") {
                // Let browser handle print normally
                // But ensure input/textarea styling is applied before print
                document.querySelectorAll("input, textarea").forEach(el => {
                    el.style.background = "transparent";
                    el.style.border = "none";
                });
            }
        });
    </script>
</body>
</html>
