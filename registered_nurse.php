<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Performance Evaluation Form</title>




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
  padding: 12px !important;
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

    /* .page {
        border: none;
        padding: 0;
        margin: 0;
    } */

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
        padding: 8px !important;
        margin-bottom: 8px !important;
        font-size: 13px !important;
    }

    .key {
        padding: 5px !important;
        margin-bottom: 8px !important;
        font-size: 13px !important;
    }

    /* Make table cells more compact */
    table th, table td {
        padding: 4px 6px !important;
        font-size: 13px !important;
        line-height: 1.4 !important;
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

    .text-col {
        padding-left: 18px !important;
        padding-right: 10px !important;
        padding-top: 3px !important;
        padding-bottom: 3px !important;
    }

    /* Reduce paragraph spacing */
    p {
        margin: 10px 0 5px 0 !important;
        font-size: 13px !important;
    }

    /* Make textareas more compact */
    textarea {
        line-height: 20px !important;
        font-size: 13px !important;
        min-height: 22px !important;
    }

    /* Compact footer section */
    .footer-section {
        margin-top: 15px !important;
        font-size: 13px !important;
    }

    .footer-section > div {
        margin-bottom: 12px !important;
    }

    .footer-section label {
        font-size: 13px !important;
    }

    .footer-section input[type="text"] {
        font-size: 13px !important;
        line-height: 20px !important;
    }

    /* Reduce top bar spacing */
    div[style*="border-bottom:5px solid"] {
        margin-bottom: 8px !important;
        padding-bottom: 3px !important;
        font-size: 14px !important;
    }

    /* Bottom copyright line spacing */
    .footer-section > div[style*="border-top"] {
        margin-top: 25px !important;
        padding-top: 6px !important;
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



        /* ===== PRINT MODE ===== */

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
            <label style="font-weight:bold;">Job Title/Position:</label> <i>Registered Nurse</i> <br>

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

        <table>
            <tr>
                <th style="width:80%;">A. Patient Care Responsibilities</th>
                <th style="width:20%;">Rating</th>
            </tr>

            <!-- Patient Care -->
            <tr>
                <td class="subheading"><b><i>Patient Care</i></b></td>
                <td></td>
            </tr>
            <tr>
                <td class="subpoint">1. Completes an initial assessment of patient and family...</td>
                <td class="rating">1 <input type="radio" name="pc1"> 2 <input type="radio" name="pc1"> 3 <input type="radio" name="pc1"> 4 <input type="radio" name="pc1"></td>
            </tr>
            <tr>
                <td class="subpoint">2. Regularly re-evaluates patient nursing needs.</td>
                <td class="rating">1 <input type="radio" name="pc2"> 2 <input type="radio" name="pc2"> 3 <input type="radio" name="pc2"> 4 <input type="radio" name="pc2"></td>
            </tr>
            <tr>
                <td class="subpoint">3. Initiates the plan of care and makes necessary revisions...</td>
                <td class="rating">1 <input type="radio" name="pc3"> 2 <input type="radio" name="pc3"> 3 <input type="radio" name="pc3"> 4 <input type="radio" name="pc3"></td>
            </tr>
            <tr>
                <td class="subpoint">4. Uses health assessment data to determine nursing diagnosis.</td>
                <td class="rating">1 <input type="radio" name="pc4"> 2 <input type="radio" name="pc4"> 3 <input type="radio" name="pc4"> 4 <input type="radio" name="pc4"></td>
            </tr>
            <tr>
                <td class="subpoint">5. Develops a care plan that establishes goals...</td>
                <td class="rating">1 <input type="radio" name="pc5"> 2 <input type="radio" name="pc5"> 3 <input type="radio" name="pc5"> 4 <input type="radio" name="pc5"></td>
            </tr>
            <tr>
                <td class="subpoint">6. Initiates appropriate preventive and rehabilitative procedures...</td>
                <td class="rating">1 <input type="radio" name="pc6"> 2 <input type="radio" name="pc6"> 3 <input type="radio" name="pc6"> 4 <input type="radio" name="pc6"></td>
            </tr>
            <tr>
                <td class="subpoint">7. Counsels the patient and family in meeting nursing needs.</td>
                <td class="rating">1 <input type="radio" name="pc7"> 2 <input type="radio" name="pc7"> 3 <input type="radio" name="pc7"> 4 <input type="radio" name="pc7"></td>
            </tr>
            <tr>
                <td class="subpoint">8. Provides health care instructions to the patient as appropriate.</td>
                <td class="rating">1 <input type="radio" name="pc8"> 2 <input type="radio" name="pc8"> 3 <input type="radio" name="pc8"> 4 <input type="radio" name="pc8"></td>
            </tr>
            <tr>
                <td class="subpoint">9. Identifies discharge planning needs prior to discharge.</td>
                <td class="rating">1 <input type="radio" name="pc9"> 2 <input type="radio" name="pc9"> 3 <input type="radio" name="pc9"> 4 <input type="radio" name="pc9"></td>
            </tr>

            <!-- Communication -->
            <tr>
                <td class="subheading"><b><i>Communication</i></b></td>
                <td></td>
            </tr>
            <tr>
                <td class="subpoint">1. Prepares clinical notes and updates the physician...</td>
                <td class="rating">1 <input type="radio" name="com1"> 2 <input type="radio" name="com1"> 3 <input type="radio" name="com1"> 4 <input type="radio" name="com1"></td>
            </tr>
            <tr>
                <td class="subpoint">2. Communicates with physician regarding patient's needs...</td>
                <td class="rating">1 <input type="radio" name="com2"> 2 <input type="radio" name="com2"> 3 <input type="radio" name="com2"> 4 <input type="radio" name="com2"></td>
            </tr>
            <tr>
                <td class="subpoint">3. Coordinates with community health persons for care plan.</td>
                <td class="rating">1 <input type="radio" name="com3"> 2 <input type="radio" name="com3"> 3 <input type="radio" name="com3"> 4 <input type="radio" name="com3"></td>
            </tr>

            <!-- Additional Duties -->
            <tr>
                <td class="subheading"><b><i>Additional Duties</i></b></td>
                <td></td>
            </tr>
            <tr>
                <td class="subpoint">1. Participates in on-call duties per policy.</td>
                <td class="rating">1 <input type="radio" name="ad1"> 2 <input type="radio" name="ad1"> 3 <input type="radio" name="ad1"> 4 <input type="radio" name="ad1"></td>
            </tr>
            <tr>
                <td class="subpoint">2. Ensures arrangements for equipment and necessary services.</td>
                <td class="rating">1 <input type="radio" name="ad2"> 2 <input type="radio" name="ad2"> 3 <input type="radio" name="ad2"> 4 <input type="radio" name="ad2"></td>
            </tr>
            <tr>
                <td class="subpoint">3. Supervises and evaluates home health aide care bi-weekly.</td>
                <td class="rating">1 <input type="radio" name="ad3"> 2 <input type="radio" name="ad3"> 3 <input type="radio" name="ad3"> 4 <input type="radio" name="ad3"></td>
            </tr>
        </table>

        <p><b>Targeted Goals For Next Review Cycle:</b></p>
        <textarea rows="1" style="
            width:100%;
            border:none;
            outline:none;
            font-family:'Times New Roman', serif;
            font-size:14px;
            line-height:25px;
            background-image: repeating-linear-gradient(to bottom, white 0px, white 22px, #000 23px);
            background-clip: content-box;
            resize: none;
        "></textarea>

        <p><b>Comments:</b></p>
        <textarea rows="1" style="
            width:100%;
            border:none;
            outline:none;
            font-family:'Times New Roman', serif;
            font-size:14px;
            line-height:25px;
            background-image: repeating-linear-gradient(to bottom, white 0px, white 22px, #000 23px);
            background-clip: content-box;
            resize: none;
        "></textarea>

        <!-- Footer -->
        <div class="footer-section" style="width:100%; margin-top:20px;">
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
                <br>
                <div style="text-align:right; white-space:nowrap;">
                    <label>Date:</label>
                    <input type="date" >
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
                    <input type="date" >
                </div>
            </div>

            <!-- Bottom Line -->
            <div style="border-top:2px solid #000; margin-top:40px; padding-top:5px;">
            </div>
        </div>
    </div>

    <!-- Page 2 -->
    <div class="page">
        <br>
        <!-- Top Bar -->
        <div style="text-align:right; font-weight:bold; border-bottom:5px solid #000; margin-bottom:10px; padding-bottom:3px;">
            Job Descriptions
        </div>

        <h2>PERFORMANCE EVALUATION</h2>

        <!-- Header -->
        <div class="header">
            <label style="font-weight:bold;">Job Title/Position:</label> <i>Registered Nurse </i>
              <br> <br>
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
            <span style="position:absolute; right:10px; bottom:5px; font-weight:bold;">Page 2</span>
        </div>

        <!-- Key -->
        <div class="key">
            <b>Key:</b> 4 = Superior Performance &nbsp;&nbsp; 
            3 = Satisfactory Performance &nbsp;&nbsp; 
            2 = Inconsistent Performance &nbsp;&nbsp; 
            1 = Unacceptable Performance
        </div>

        <!-- Section C Table -->
        <table>
            <tr>
                <th style="width:80%; text-align: left;">B. Organizational Responsibilities</th>
                <th style="width:20%;">Rating</th>
            </tr>

            <tr>
                <td class="text-col">1. Adheres to patient assignments as directed by immediate Clinical Supervisor/Nursing Supervisor.</td>
                <td class="rating-col">1<input type="radio" name="r1"> 2<input type="radio" name="r1"> 3<input type="radio" name="r1"> 4<input type="radio" name="r1"></td>
            </tr>

            <tr>
                <td class="text-col">2. Nursing care is covered by medical orders from the physician as appropriate.</td>
                <td class="rating-col">1<input type="radio" name="r2"> 2<input type="radio" name="r2"> 3<input type="radio" name="r2"> 4<input type="radio" name="r2"></td>
            </tr>

            <tr>
                <td class="text-col">
                    3. Maintains an acceptable work record.<br><br>
                    <input type="text" style="border: none; border-bottom: 1px solid #000; outline: none; width: 80px; background: transparent; text-align: center;"> Days Tardy 
                    &nbsp;&nbsp;&nbsp; 
                    <input type="text" style="border: none; border-bottom: 1px solid #000; outline: none; width: 80px; background: transparent; text-align: center;"> Days Absent
                </td>
                <td class="rating-col">1<input type="radio" name="r3"> 2<input type="radio" name="r3"> 3<input type="radio" name="r3"> 4<input type="radio" name="r3"></td>
            </tr>

            <tr>
                <td class="text-col">4. Informs coordinator of availability weekly.</td>
                <td class="rating-col">1<input type="radio" name="r4"> 2<input type="radio" name="r4"> 3<input type="radio" name="r4"> 4<input type="radio" name="r4"></td>
            </tr>

            <tr>
                <td class="text-col">5. Reviews policy manual when patient care procedures and organization personnel procedures need clarification.</td>
                <td class="rating-col">1<input type="radio" name="r5"> 2<input type="radio" name="r5"> 3<input type="radio" name="r5"> 4<input type="radio" name="r5"></td>
            </tr>

            <tr>
                <td class="text-col">6. Accepts responsibility for behavior and activity.</td>
                <td class="rating-col">1<input type="radio" name="r6"> 2<input type="radio" name="r6"> 3<input type="radio" name="r6"> 4<input type="radio" name="r6"></td>
            </tr>

            <tr>
                <td class="text-col">7. Is respectful of individual's rights in interacting with patients, families/caregivers and coworkers.</td>
                <td class="rating-col">1<input type="radio" name="r7"> 2<input type="radio" name="r7"> 3<input type="radio" name="r7"> 4<input type="radio" name="r7"></td>
            </tr>

            <tr>
                <td class="text-col">8. Follows organization guidelines in practice of:<br>
                    (a) Infection Control 
                    (b) Fire/Safety 
                    (c) Patient Care Standards
                </td>
                <td class="rating-col">1<input type="radio" name="r8"> 2<input type="radio" name="r8"> 3<input type="radio" name="r8"> 4<input type="radio" name="r8"></td>
            </tr>

            <tr>
                <td class="text-col">9. Displays appropriate management of equipment and supplies (acquisition to distribution).</td>
                <td class="rating-col">1<input type="radio" name="r9"> 2<input type="radio" name="r9"> 3<input type="radio" name="r9"> 4<input type="radio" name="r9"></td>
            </tr>

            <tr>
                <td class="text-col">10. Participates in organization quality activities to improve organizational performance.</td>
                <td class="rating-col">1<input type="radio" name="r10"> 2<input type="radio" name="r10"> 3<input type="radio" name="r10"> 4<input type="radio" name="r10"></td>
            </tr>

            <tr>
                <td class="text-col">11. Interacts collaboratively with all team members.</td>
                <td class="rating-col">1<input type="radio" name="r11"> 2<input type="radio" name="r11"> 3<input type="radio" name="r11"> 4<input type="radio" name="r11"></td>
            </tr>
        </table>

        <br>

        <!-- Targeted Goals and Comments -->
        <p><b>Targeted Goals For Next Review Cycle:</b></p>
        <textarea rows="2" style="
            width:100%;
            outline:none;
            font-family:'Times New Roman', serif;
            font-size:14px;
            line-height:25px;
            background-image: repeating-linear-gradient(to bottom, white 0px, white 22px, #000 23px);
            background-clip: content-box;
            resize: none;
        "></textarea>

        <p><b>Comments:</b></p>
        <textarea rows="2" style="
            width:100%;
            outline:none;
            font-family:'Times New Roman', serif;
            font-size:14px;
            line-height:25px;
            background-image: repeating-linear-gradient(to bottom, white 0px, white 22px, #000 23px);
            background-clip: content-box;
            resize: none;
        "></textarea>

        <!-- Footer -->
        <div class="footer-section" style="width:100%; margin-top:20px;">
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
                    <input type="date" >
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
                    <input type="date" >
                </div>
            </div>

            <!-- Bottom Line -->
            <div style="border-top:2px solid #000; margin-top:40px; padding-top:5px;">
            </div>
        </div>
    </div>

    <!-- Page 3 -->
    <div class="page">
        <!-- ============ PAGE 3 ============ -->
        <div style="text-align:right; font-weight:bold; border-bottom:5px solid #000; margin-bottom:10px; padding-bottom:3px;">
            Job Descriptions
        </div>

        <h2>PERFORMANCE EVALUATION</h2>

        <div class="header">
            <label>Job Title/Position:</label> <i>Registered Nurse </i>  <br> <br>
            <label>Date:</label> <input type="date" name="review_date3"> <br><br>
            <label>Reviewer:</label> <input type="text" name="reviewer_name3" style="width:200px; margin-right:20px;"> 
            <span class="reviewer-options">
                <label><input type="checkbox" name="reviewer3" value="Annual"> Annual</label>
                <label><input type="checkbox" name="reviewer3" value="90 Day"> 90 Day</label>
                <label><input type="checkbox" name="reviewer3" value="Other"> Other</label>
            </span>
            <span style="position:absolute; right:10px; bottom:5px; font-weight:bold;">Page 3</span>
        </div>

        <div class="key">
            <b>Key:</b> 4 = Superior Performance &nbsp;&nbsp; 
            3 = Satisfactory Performance &nbsp;&nbsp; 
            2 = Inconsistent Performance &nbsp;&nbsp; 
            1 = Unacceptable Performance
        </div>

        <!-- Education/Inservice Responsibilities -->
        <table>
            <tr>
                <th style="width:80%; text-align: left;">C. Educational/Inservice Responsibilities</th>
                <th style="width:20%;">Rating</th>
            </tr>

            <tr>
                <td class="text-col">1. Completes CPR program annually.</td>
                <td class="rating-col">1<input type="radio" name="edu1"> 2<input type="radio" name="edu1"> 3<input type="radio" name="edu1"> 4<input type="radio" name="edu1"></td>
            </tr>

            <tr>
                <td class="text-col">2. Fire/Safety, Emergency Management, Infection Control, Ethics, and Performance Improvement programs are attended annually.</td>
                <td class="rating-col">1<input type="radio" name="edu2"> 2<input type="radio" name="edu2"> 3<input type="radio" name="edu2"> 4<input type="radio" name="edu2"></td>
            </tr>

            <tr>
                <td class="text-col">3. Attends inservices quarterly and identifies self-learning goals.</td>
                <td class="rating-col">1<input type="radio" name="edu3"> 2<input type="radio" name="edu3"> 3<input type="radio" name="edu3"> 4<input type="radio" name="edu3"></td>
            </tr>

            <tr>
                <td class="text-col">4. Completes annual competency skills checklist.</td>
                <td class="rating-col">1<input type="radio" name="edu4"> 2<input type="radio" name="edu4"> 3<input type="radio" name="edu4"> 4<input type="radio" name="edu4"></td>
            </tr>
        </table>


        <!-- Targeted Goals and Comments -->
        <p><b>Targeted Goals For Next Review Cycle:</b></p>
        <textarea rows="2" style="
            width:100%;
            border:none;
            outline:none;
            font-family:'Times New Roman', serif;
            font-size:14px;
            line-height:25px;
            background-image: repeating-linear-gradient(to bottom, white 0px, white 22px, #000 23px);
            background-clip: content-box;
            resize: none;
        "></textarea>

        <p><b>Comments:</b></p>
        <textarea rows="2" style="
            width:100%;
            border:none;
            outline:none;
            font-family:'Times New Roman', serif;
            font-size:14px;
            line-height:25px;
            background-image: repeating-linear-gradient(to bottom, white 0px, white 22px, #000 23px);
            background-clip: content-box;
            resize: none;
        "></textarea>

        <!-- Footer -->
        <div class="footer-section" style="width:100%; margin-top:20px;">
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
                    <input type="date" >
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
                    <input type="date" >
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
                    formType: 'RN'
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