<?php
$directory = __DIR__;
$excludeFiles = array('index.php', 'icon.php', 'delete.php'); // Add filenames to exclude here
$files = scandir($directory);

// Sort files by last modified date
usort($files, function($a, $b) use ($directory) {
    $fileA = $directory . DIRECTORY_SEPARATOR . $a;
    $fileB = $directory . DIRECTORY_SEPARATOR . $b;
    $lastModifiedA = filemtime($fileA);
    $lastModifiedB = filemtime($fileB);

    return $lastModifiedB - $lastModifiedA; // Sort in descending order
});
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Files</title>
    <style>
        table {
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 5px;
        }
    </style>
</head>
<body>
    <h1>Delete Files</h1>
    <button onclick="window.location.href = '/uploads/index.php';">Go to Uploads</button>
    <table>
        <tr>
            <th>File Name</th>
            <th>Last Modified</th>
            <th>Action</th>
        </tr>
        <?php foreach ($files as $file) {
            if ($file === '.' || $file === '..' || in_array($file, $excludeFiles)) {
                continue;
            }
            $filePath = $directory . DIRECTORY_SEPARATOR . $file;
            $lastModified = date("Y-m-d H:i:s", filemtime($filePath));
            ?>
            <tr>
                <td><?php echo $file; ?></td>
                <td><?php echo $lastModified; ?></td>
                <td>
                    <a href="<?php echo $file; ?>" target="_blank">
                        <button>View</button>
                    </a>
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="file" value="<?php echo $file; ?>">
                        <input type="submit" name="delete" value="Delete">
                    </form>
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="file" value="<?php echo $file; ?>">
                        <label>New Name:</label>
                        <input type="text" name="newName" required>
                        <input type="submit" name="rename" value="Rename">
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>


    <?php
    if (isset($_POST['delete'])) {
        $fileToDelete = $_POST['file'];
        $filePath = $directory . DIRECTORY_SEPARATOR . $fileToDelete;
        if (file_exists($filePath)) {
            unlink($filePath);
            echo "<p>File '$fileToDelete' has been deleted.</p>";
        } else {
            echo "<p>File '$fileToDelete' does not exist.</p>";
        }
    }

    if (isset($_POST['rename'])) {
        $fileToRename = $_POST['file'];
        $newName = $_POST['newName'];
        $filePath = $directory . DIRECTORY_SEPARATOR . $fileToRename;
        $newFilePath = $directory . DIRECTORY_SEPARATOR . $newName;
        if (file_exists($filePath)) {
            if (rename($filePath, $newFilePath)) {
                echo "<p>File '$fileToRename' has been renamed to '$newName'.</p>";
            } else {
                echo "<p>Failed to rename file '$fileToRename'.</p>";
            }
        } else {
            echo "<p>File '$fileToRename' does not exist.</p>";
        }
    }
    ?>
</body>
</html>
