<?php
// Database connection - PORT 3307
$conn = new mysqli("localhost:3307", "root", "", "test_db");

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

$search = "";

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    // Using prepared statement for SECURITY
    $stmt = $conn->prepare("SELECT * FROM contacts WHERE name LIKE ?");
    $search_term = "%" . $search . "%";
    $stmt->bind_param("s", $search_term);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM contacts");
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        h2 {
            color: #333;
            margin-bottom: 30px;
            text-align: center;
            font-size: 28px;
        }

        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .search-box {
            flex: 1;
            min-width: 250px;
        }

        .search-box form {
            display: flex;
            gap: 10px;
        }

        input[type="text"] {
            flex: 1;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus {
            outline: none;
            border-color: #667eea;
        }

        button {
            padding: 12px 25px;
            border: none;
            background: #667eea;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s;
        }

        button:hover {
            background: #764ba2;
        }

        .back-link {
            display: inline-block;
            padding: 10px 20px;
            background: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .back-link:hover {
            background: #5a6268;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-top: 20px;
        }

        th {
            background: #667eea;
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: bold;
        }

        td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background: #f5f5f5;
        }

        .action-links {
            display: flex;
            gap: 10px;
        }

        a {
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            font-size: 12px;
            transition: 0.3s;
        }

        a.edit {
            background: #28a745;
            color: white;
        }

        a.edit:hover {
            background: #218838;
        }

        a.delete {
            background: #dc3545;
            color: white;
        }

        a.delete:hover {
            background: #c82333;
        }

        .no-data {
            text-align: center;
            padding: 30px;
            color: #666;
            font-size: 16px;
        }

        .success {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            table {
                font-size: 12px;
            }

            td, th {
                padding: 8px;
            }

            .action-links {
                flex-direction: column;
                gap: 5px;
            }

            a {
                padding: 4px 8px;
                font-size: 10px;
            }
        }
    </style>
</head>

<body>

<div class="container">
    <h2>📋 Admin Dashboard - Messages</h2>

    <div class="header-actions">
        <div class="search-box">
            <form method="GET">
                <input type="text" name="search" placeholder="Search by name..." value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit">🔍 Search</button>
            </form>
        </div>
        <a href="index.html" class="back-link">← Back to Portfolio</a>
    </div>

    <?php if ($search): ?>
        <div class="success">
            Search results for: <strong><?php echo htmlspecialchars($search); ?></strong>
        </div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>#" . htmlspecialchars($row['id']) . "</td>
                        <td><strong>" . htmlspecialchars($row['name']) . "</strong></td>
                        <td>" . htmlspecialchars($row['email']) . "</td>
                        <td>" . htmlspecialchars(substr($row['message'], 0, 50)) . "...</td>
                        <td>
                            <div class='action-links'>
                                <a href='edit.php?id=" . htmlspecialchars($row['id']) . "' class='edit'>✏️ Edit</a>
                                <a href='delete.php?id=" . htmlspecialchars($row['id']) . "' class='delete' onclick=\"return confirm('Are you sure you want to delete this message?')\">🗑️ Delete</a>
                            </div>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='no-data'>No messages found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>