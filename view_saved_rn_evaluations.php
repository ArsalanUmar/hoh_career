<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Saved RN Evaluations</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    
    <style>
        body {
            font-family: Poppins-Regular, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }
        
        .page-header {
            background: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .page-header h2 {
            margin: 0;
            color: #333;
            font-family: Poppins-SemiBold, sans-serif;
        }
        
        .page-header p {
            margin: 5px 0 0 0;
            color: #666;
        }
        
        .toolbar {
            background: #fff;
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .search-box {
            position: relative;
            display: inline-block;
            width: 100%;
            max-width: 300px;
        }
        
        .search-box input {
            width: 100%;
            padding: 8px 35px 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: Poppins-Regular, sans-serif;
        }
        
        .search-box input:focus {
            border-color: #17a2b8;
            outline: none;
        }
        
        .search-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }
        
        .btn-back {
            background: #616161;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 4px;
            font-family: Poppins-Regular, sans-serif;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }
        
        .btn-back:hover {
            background-color: #000000;
            color: white;
            text-decoration: none;
        }
        
        .stats-box {
            background: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .stat-item {
            text-align: center;
            padding: 15px;
            background: #17a2b8;
            color: white;
            border-radius: 4px;
        }
        
        .stat-item h3 {
            font-size: 32px;
            margin: 0;
            font-family: Poppins-Bold, sans-serif;
        }
        
        .stat-item p {
            margin: 5px 0 0 0;
            color: white;
            font-size: 14px;
        }
        
        .table-container {
            background: #fff;
            padding: 20px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .table thead th {
            border-top: none;
            background: #f8f9fa;
            color: #333;
            font-family: Poppins-SemiBold, sans-serif;
            font-weight: 600;
        }
        
        .table tbody tr:hover {
            background: #f8f9fa;
        }
        
        .employee-name {
            font-weight: 600;
            color: #17a2b8;
            font-family: Poppins-Medium, sans-serif;
        }
        
        .btn-action {
            padding: 5px 12px;
            border-radius: 4px;
            font-size: 13px;
            margin-right: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s;
            font-family: Poppins-Regular, sans-serif;
        }
        
        .btn-view {
            background: #17a2b8;
            color: white;
            border: 1px solid #17a2b8;
        }
        
        .btn-view:hover {
            background-color: #fff;
            color: #000;
            border: 1px solid #000;
            text-decoration: none;
        }
        
        .btn-download {
            background: #616161;
            color: white;
            border: 1px solid #616161;
        }
        
        .btn-download:hover {
            background: #000000;
            border: 1px solid #000000;
            text-decoration: none;
        }
        
        .btn-delete {
            background: #dc3545;
            color: white;
            border: 1px solid #dc3545;
        }
        
        .btn-delete:hover {
            background: #c82333;
            border: 1px solid #c82333;
        }
        
        .no-results {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }
        
        .no-results i {
            font-size: 64px;
            margin-bottom: 20px;
            color: #ddd;
        }
        
        .no-results h3 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #333;
            font-family: Poppins-SemiBold, sans-serif;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h2><i class="fa fa-file-text"></i> Saved Performance Evaluations</h2>
            <p>View, print, or download all saved performance evaluations (RN, LPN/LVN, Home Health Aide)</p>
        </div>
        
        <!-- Toolbar -->
        <div class="toolbar">
            <div class="row">
                <div class="col-md-4">
                    <a href="manage/" class="btn-back">
                        <i class="fa fa-arrow-left"></i> Back to Manage
                    </a>
                </div>
                <div class="col-md-4 text-center">
                    <div class="search-box" style="margin: 0 auto;">
                        <input type="text" id="searchInput" placeholder="Search by employee name..." onkeyup="filterTable()">
                        <span class="search-icon"><i class="fa fa-search"></i></span>
                    </div>
                </div>
                <div class="col-md-4 text-right">
                    <!-- New Evaluation button removed -->
                </div>
            </div>
        </div>
        
        <!-- Stats -->
        <div class="stats-box">
            <div class="row">
                <div class="col-md-3">
                    <div class="stat-item">
                        <h3 id="totalCount">0</h3>
                        <p>Total Evaluations</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Table -->
        <div class="table-container">
            <table class="table table-hover" id="evaluationsTable">
                <thead>
                    <tr>
                        <th>Employee Name</th>
                        <th>Form Type</th>
                        <th>Date Created</th>
                        <th>File Size</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <!-- Data will be loaded here -->
                </tbody>
            </table>
            
            <div id="noResults" class="no-results" style="display: none;">
                <i class="fa fa-inbox"></i>
                <h3>No Evaluations Found</h3>
                <p>Start by creating a new evaluation using the button above.</p>
            </div>
        </div>
    </div>
    
    <!-- jQuery -->
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    
    <script>
        // Load evaluations on page load
        document.addEventListener('DOMContentLoaded', loadEvaluations);

        function loadEvaluations() {
            fetch('get_all_evaluations.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayEvaluations(data.evaluations);
                        document.getElementById('totalCount').textContent = data.evaluations.length;
                    } else {
                        showNoResults();
                    }
                })
                .catch(error => {
                    console.error('Error loading evaluations:', error);
                    showNoResults();
                });
        }

        function displayEvaluations(evaluations) {
            const tableBody = document.getElementById('tableBody');
            const noResults = document.getElementById('noResults');
            
            if (evaluations.length === 0) {
                showNoResults();
                return;
            }

            noResults.style.display = 'none';
            tableBody.innerHTML = '';

            evaluations.forEach(evaluation => {
                const row = document.createElement('tr');
                const badgeColors = {
                    'RN': 'primary',
                    'LPN': 'success',
                    'HHA': 'info',
                    'OfficeStaff': 'warning'
                };
                const badgeColor = badgeColors[evaluation.formType] || 'secondary';
                
                row.innerHTML = `
                    <td class="employee-name">${escapeHtml(evaluation.employeeName)}</td>
                    <td><span class="badge badge-${badgeColor}">${escapeHtml(evaluation.formTypeName)}</span></td>
                    <td>${formatDate(evaluation.dateCreated)}</td>
                    <td>${evaluation.fileSize}</td>
                    <td>
                        <a href="${evaluation.filepath}" target="_blank" class="btn-action btn-view">
                            <i class="fa fa-eye"></i> View
                        </a>
                        <a href="${evaluation.filepath}" download class="btn-action btn-download">
                            <i class="fa fa-download"></i> Download
                        </a>
                        <button onclick="deleteEvaluation('${evaluation.filename}')" class="btn-action btn-delete">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        function showNoResults() {
            document.getElementById('tableBody').innerHTML = '';
            document.getElementById('noResults').style.display = 'block';
        }

        function filterTable() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('evaluationsTable');
            const rows = table.getElementsByTagName('tr');

            let visibleCount = 0;

            for (let i = 1; i < rows.length; i++) {
                const nameCell = rows[i].getElementsByClassName('employee-name')[0];
                if (nameCell) {
                    const txtValue = nameCell.textContent || nameCell.innerText;
                    if (txtValue.toLowerCase().indexOf(filter) > -1) {
                        rows[i].style.display = '';
                        visibleCount++;
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            }

            if (visibleCount === 0 && filter !== '') {
                document.getElementById('noResults').style.display = 'block';
            } else {
                document.getElementById('noResults').style.display = 'none';
            }
        }

        function deleteEvaluation(filename) {
            if (!confirm('Are you sure you want to delete this evaluation? This action cannot be undone.')) {
                return;
            }

            fetch('delete_evaluation.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ filename: filename })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Evaluation deleted successfully');
                    loadEvaluations();
                } else {
                    alert('Error deleting evaluation: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while deleting the evaluation.');
            });
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    </script>
</body>
</html>
