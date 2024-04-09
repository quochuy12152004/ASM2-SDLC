<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student List</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

  <style>
    /* // background img// */
  body {
    background-image: url('https://gcs.tripi.vn/public-tripi/tripi-feed/img/474087ejw/hinh-anh-background-dep-don-gian_102938083.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
  }
</style>


</head>

<body class="bg-gray-100">

  <div class="container mx-auto my-10 px-4">
    <h1 class="text-3xl font-semibold mb-6 text-gray-800">Student List</h1>
    <div class="flex justify-between items-center mb-6">
      <a class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded" href="/fpi/addstudent_page.php" role="button">Add Student</a>
      <a class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded" href="/fpi/logout.php" role="button">LogOut</a>
    </div>

    <!-- Search -->
    <div class="mb-6">
      <input type="text" id="searchInput" class="border border-gray-300 px-4 py-2 rounded-md w-full" placeholder="Search...">
    </div>
    <button id="searchButton" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Search</button>

    <div class="overflow-x-auto">
      <table class="table-auto w-full">
        <thead>
          <tr class="bg-gray-200">
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">MASV</th>
            <th class="px-4 py-2">Full Name</th>
            <th class="px-4 py-2">Email</th>
            <th class="px-4 py-2">Password</th>
            <th class="px-4 py-2">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Database connection settings
          $_servername = "localhost";
          $_username = "root";
          $_password = "";
          $_dbname = "btec-list student";

          // Create connection;
          $conn = new mysqli($_servername, $_username, $_password, $_dbname);

          // Check connection
          if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
          }

          // Read all rows from database table
          $query = "SELECT * FROM users";
          $result = $conn->query($query);

          if (!$result) {
            die("Invalid query: "  .  $conn->error);
          }

          // Read data of each row
          while ($row = $result->fetch_assoc()) {
            echo "
            <tr class='border-b border-gray-200'>
              <td class='px-4 py-3'>$row[id]</td>
              <td class='px-4 py-3'>$row[masv]</td>
              <td class='px-4 py-3'>$row[fullname]</td>
              <td class='px-4 py-3'>$row[email]</td>
              <td class='px-4 py-3'>$row[password]</td>
              <td class='px-4 py-3'>
                <a class='text-blue-500 hover:text-blue-700 mr-2' href='/fpi/update.php?id=$row[id]'>Edit</a>
                <a class='text-red-500 hover:text-red-700' href='/fpi/deletestudent_page.php?id=$row[id]'>Delete</a>
              </td>
            </tr>
            ";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- scrip for search -->
  <script>
    document.getElementById("searchButton").addEventListener("click", function() {
      var searchText = document.getElementById("searchInput").value.toLowerCase();
      var table = document.getElementsByTagName("table")[0];
      var rows = table.getElementsByTagName("tr");
      
      for (var i = 1; i < rows.length; i++) {
        var cells = rows[i].getElementsByTagName("td");
        var found = false;
        
        for (var j = 0; j < cells.length; j++) {
          var cellText = cells[j].innerText.toLowerCase();
          if (cellText.indexOf(searchText) > -1) {
            found = true;
            break;
          }
        }
        
        if (found) {
          rows[i].style.display = "";
        } else {
          rows[i].style.display = "none";
        }
      }
    });
  </script>

  <style>
    tr[style="display: none;"] {
      display: none !important;
    }
  </style>

</body>

</html>



