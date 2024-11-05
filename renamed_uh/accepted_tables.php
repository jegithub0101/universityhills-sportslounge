<!DOCTYPE html>
<html>
<head>
    <title>Accepted Tables</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .table td, .table th {
            vertical-align: middle;
        }
        .card-header {
            background-color: #343a40;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mt-3 mb-4">Accepted Tables</h2>

        <div class="card">
            <div class="card-header">
                <h3>Accepted Tables</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Table Number</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody id="accepted-tables-body">
                            <!-- Accepted tables will be loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mt-3">
            <button class="btn btn-danger" id="clear-accepted-tables">Clear</button>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            loadAcceptedTables();
        });

        function loadAcceptedTables() {
            $.ajax({
                url: 'fetch_accepted_tables.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var tableRows = '';
                    $.each(data, function(index, table) {
                        tableRows += '<tr>' +
                            '<td>' + table.table_number + '</td>' +
                            '<td>' + table.price + '</td>' +
                            '</tr>';
                    });
                    $('#accepted-tables-body').html(tableRows);
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        }

        $(document).ready(function() {
            loadAcceptedTables();

            // Clear button click event
            $('#clear-accepted-tables').click(function() {
                if (confirm('Are you sure you want to clear all accepted tables?')) {
                    clearAcceptedTables();
                }
            });
        });

    </script>

    <script>
        function clearAcceptedTables() {
            $.ajax({
                url: 'clear_accepted_tables.php',
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert('All accepted tables have been cleared.');
                        loadAcceptedTables(); // Reload the accepted tables
                    } else {
                        alert('Error clearing accepted tables: ' + response.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error);
                    alert('An error occurred while clearing accepted tables.');
                }
            });
        }
    </script>
</body>
</html>