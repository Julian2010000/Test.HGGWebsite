<!DOCTYPE html>
<html>

<head>
    <title>Admin Panel</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #121212;
            color: #e0e0e0;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 20px auto;
        }

        .panel {
            background-color: #1e1e1e;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
        }

        .panel h2 {
            color: #bb86fc;
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #333;
        }

        th {
            background-color: #2c2c2c;
        }

        .delete-button {
            background-color: #d32f2f;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
        }

        .kill-button {
            background-color: #ff9800;
            color: black;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
    <script>
        function confirmDelete(postId) {
            if (confirm("Sind Sie sicher, dass Sie diesen Post löschen möchten?")) {
                // Send an AJAX request to delete the file
                fetch('delete_post.php', {
                        // Replace 'delete_post.php' with the actual path to your PHP script
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'postId=' + postId
                    })
                    .then(response => response.text())
                    .then(data => {
                        alert(data); // Show the server's response (e.g., "Post deleted successfully")
                        // Optionally, you can also remove the post's HTML element from the page here
                        location.reload(); // Reload the page to update the post list
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
            }
        }

        function confirmKill() {
            var password = prompt("Bitte geben Sie das Website-Kill-Passwort ein:");
            if (password === "L+D\\b%LLmg") {
                // Hier serverseitige Logik zum Deaktivieren der Website einfügen
                alert("Website wurde gekillt.");
            } else {
                alert("Falsches Passwort.");
            }
        }
    </script>
</head>

<body>
    <div class="container">
        <div class="panel">
            <h2>Blog-Posts verwalten</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titel</th>
                        <th>Datum</th>
                        <th>Aktionen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $directory = './'; // Adjust this to the directory where your blog files are stored
                    $files = glob($directory . 'blog-*.php');

                    if (empty($files)) {
                        echo '<tr><td colspan="4">No blog posts found.</td></tr>';
                    } else {
                        foreach ($files as $file) {
                            $filename = basename($file);
                            // Extract post ID from filename (assuming it's like blog-123.php)
                            $postId = str_replace(['blog-', '.php'], '', $filename);

                            // You'll need to implement logic to extract the title and date from the file content
                            // This depends on how you store your blog post data within the files
                            // For example, if you have specific tags or a standard format, you can use PHP's file handling functions
                            // to read the file and parse the content.
                            $postTitle = "Titel nicht gefunden"; // Placeholder - Implement your title extraction logic here
                            $postDate = "Datum nicht gefunden"; // Placeholder - Implement your date extraction logic here

                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($postId) . '</td>';
                            echo '<td>' . htmlspecialchars($postTitle) . '</td>';
                            echo '<td>' . htmlspecialchars($postDate) . '</td>';
                            echo '<td><button class="delete-button" onclick="confirmDelete(' . htmlspecialchars($postId) . ')">Löschen</button></td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="panel">
            <h2>Letzte Datenbankänderungen</h2>
            <p>Letzte Änderung: 2024-10-27, 14:30 Uhr</p>
        </div>

        <button class="kill-button" onclick="confirmKill()">Website KILL</button>
    </div>
</body>

</html>