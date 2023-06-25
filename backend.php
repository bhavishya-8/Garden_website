<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize the input data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Validate the required fields
    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {
        // Sanitize the input data
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $subject = filter_var($subject, FILTER_SANITIZE_STRING);
        $message = filter_var($message, FILTER_SANITIZE_STRING);

        // Create a new PDO instance for database connection
        $dsn = 'mysql:host=localhost;dbname=formdata';
        $username = 'root';
        $password = '';
        $pdo = new PDO($dsn, $username, $password);

        // Prepare and execute the SQL query
        $sql = "INSERT INTO mytable (name, email, subject, message) VALUES (:name, :email, :subject, :message)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':message', $message);
        $stmt->execute();

        // Close the database connection
        $pdo = null;

        // Redirect back to the HTML form page
        header('Location: contact.php');
        exit;
    } else {
        // Handle validation errors
        echo "Please fill in all the required fields.";
    }
}
?>
