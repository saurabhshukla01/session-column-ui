<!DOCTYPE html>
<html>
<head>
    <title>Dynamic Table</title>
    <style>
        table {
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
        }
    </style>
</head>
<body>
    <h2>Dynamic Table</h2>
    <table id="dynamicTable">
    @if ($blogsCount == 0)
        <thead>
            <tr>
                <th>Action</th>
                <th>Slot 1</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <button class="add">Add Column</button>
                    <button class="update">Update</button>
                </td>
                <td>
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <input type="text" class="input" name="number_1[]" value="0"><br>
                    <input type="text" class="input" name="number_2[]" value="0"><br>
                    <input type="text" class="input" name="number_3[]" value="0">
                </td>
            </tr>
        </tbody>
    @else
        <thead>
            <tr>
                <th>Action</th>
                @for ($i = 0; $i < $blogsCount; $i++)
                    <th>Slot {{ $i + 1}}</th>
                @endfor
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <button class="add">Add Column</button>
                    <button class="update">Update</button>
                </td>
                @if ($blogsCount > 0)
                    @php
                    $i = 1;
                    @endphp
                    @foreach ($blogs as $blog)
                        <td>
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                            <input type="text" class="input" name="number_1[]" value="{{ $blog->number_1 }}"><br>
                            <input type="text" class="input" name="number_2[]" value="{{ $blog->number_2 }}"><br>
                            <input type="text" class="input" name="number_3[]" value="{{ $blog->number_3 }}">
                        </td>
                        @php
                        $i++;
                        @endphp
                    @endforeach
                @endif

            </tr>
        </tbody>
    @endif
</table>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        var columnCount = <?php if ($blogsCount > 0) { echo $blogsCount + 1; } else { echo 2; } ?>;
        var rowCount = 1;

        $('.add').click(function () {
            var newColumn = '<th>Slot ' + columnCount + '</th>';
            $('#dynamicTable thead tr').append(newColumn);

            // Add a cell for each row in the table
            $('#dynamicTable tbody tr').each(function () {
                $(this).append('<td><input type="text" class="input" name="number_1[]" value="0"><br><input type="text" class="input" name="number_2[]" value="0"><br><input type="text" class="input" name="number_3[]" value="0"></td>');
            });

            columnCount++;
        });

        $('.update').click(function () {
            var dataToSend = [];

            // Iterate through each row
            $('#dynamicTable tbody tr').each(function (rowIndex) {
                var rowData = {};
                $(this).find('.input').each(function (columnIndex) {
                    var columnName = 'number_' + (columnIndex + 1);
                    var updatedValue = $(this).val();
                    rowData[columnName] = updatedValue;
                });
                dataToSend.push(rowData);
            });

            // Send the data to the server via AJAX
            $.ajax({
                type: 'POST',
                url: '/update-blog-data', // Replace with your server-side endpoint
                data: JSON.stringify(dataToSend),
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log('Data sent to the server. Server response:', response);
                },
                error: function(error) {
                    console.error('Error sending data to the server:', error);
                }
            });
        });
    </script>
</body>
</html>