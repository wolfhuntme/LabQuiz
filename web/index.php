<?php
// Simple web application with XSS and SQL injection validation

function validateInput($input) {
    // Trim whitespace
    $input = trim($input);
    
    // Check for XSS patterns (OWASP C5: Validate All Inputs)
    $xss_patterns = [
        '/<script/i',
        '/<\/script>/i',
        '/javascript:/i',
        '/on\w+\s*=/i',
        '/<iframe/i',
        '/<object/i',
        '/<embed/i',
        '/vbscript:/i',
        '/<img.*src.*=/i'
    ];
    
    foreach ($xss_patterns as $pattern) {
        if (preg_match($pattern, $input)) {
            return 'XSS';
        }
    }
    
    // Check for SQL injection patterns
    $sql_patterns = [
        '/union\s+select/i',
        '/or\s+1\s*=\s*1/i',
        '/drop\s+table/i',
        '/delete\s+from/i',
        '/insert\s+into/i',
        '/update\s+\w+\s+set/i',
        '/;\s*--/i',
        '/\/\*.*\*\//i',
        "/'.*or.*'/i",
        '/\bselect\b.*\bfrom\b/i'
    ];
    
    foreach ($sql_patterns as $pattern) {
        if (preg_match($pattern, $input)) {
            return 'SQL';
        }
    }
    
    return 'SAFE';
}

// Handle form submission
$search_term = '';
$validation_result = '';

if ($_POST && isset($_POST['search_term'])) {
    $search_term = $_POST['search_term'];
    $validation_result = validateInput($search_term);
    
    if ($validation_result === 'SAFE') {
        // Redirect to results page
        header('Location: results.php?q=' . urlencode($search_term));
        exit;
    } else {
        // Clear input and stay on homepage
        $search_term = '';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Application</title>
</head>
<body>
    <h1>Search Application</h1>
    
    <?php if ($validation_result === 'XSS'): ?>
        <p style="color: red;">XSS attack detected. Input cleared.</p>
    <?php elseif ($validation_result === 'SQL'): ?>
        <p style="color: red;">SQL injection detected. Input cleared.</p>
    <?php endif; ?>
    
    <form method="POST" action="">
        <label for="search_term">Enter search term:</label><br>
        <input type="text" id="search_term" name="search_term" value="<?php echo htmlspecialchars($search_term); ?>" required><br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>