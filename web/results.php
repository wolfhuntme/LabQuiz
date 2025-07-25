<?php
// Results page to display validated search term

$search_term = isset($_GET['q']) ? $_GET['q'] : '';
?>

<!DOCTYPE html>
-<html>
+<html lang="en" xml:lang="en">

<head>
    <title>Search Results</title>
</head>
<body>
    <h1>Search Results</h1>
    
    <?php if ($search_term): ?>
        <p>You searched for: <strong><?php echo htmlspecialchars($search_term); ?></strong></p>
    <?php else: ?>
        <p>No search term provided.</p>
    <?php endif; ?>
    
    <a href="index.php">Back to Search</a>
</body>
</html>

