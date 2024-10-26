<?php
$conn = mysqli_connect("localhost", "zhar", "qwe123qwe", "testdb");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$search_nama = isset($_GET['nama']) ? $_GET['nama'] : '';
$search_alamat = isset($_GET['alamat']) ? $_GET['alamat'] : '';

$sql = "SELECT DISTINCT p.nama, p.alamat, GROUP_CONCAT(h.hobi SEPARATOR ', ') as hobi_list 
        FROM person p 
        LEFT JOIN hobi h ON p.id = h.person_id
        WHERE 1=1";

if (!empty($search_nama)) {
    $sql .= " AND p.nama LIKE '%" . mysqli_real_escape_string($conn, $search_nama) . "%'";
}

if (!empty($search_alamat)) {
    $sql .= " AND p.alamat LIKE '%" . mysqli_real_escape_string($conn, $search_alamat) . "%'";
}

$sql .= " GROUP BY p.id, p.nama, p.alamat";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Person and Hobbies List</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        .search-form {
            border: 1px solid black;
            padding: 20px;
            margin-bottom: 20px;
            display: inline-block;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Hobi</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['nama'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($row['alamat'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($row['hobi_list'] ?? ''); ?></td>
            </tr>
        <?php } ?>
    </table>

    <div class="search-form">
        <form action="" method="GET">
            <div>
                <label>Nama: </label>
                <input type="text" name="nama" value="<?php echo htmlspecialchars($search_nama); ?>">
            </div>
            <div style="margin-top: 10px;">
                <label>Alamat: </label>
                <input type="text" name="alamat" value="<?php echo htmlspecialchars($search_alamat); ?>">
            </div>
            <div style="margin-top: 10px;">
                <input type="submit" value="SEARCH">
            </div>
        </form>
    </div>
</body>

</html>

<?php
mysqli_close($conn);
?>