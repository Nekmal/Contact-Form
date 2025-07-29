<?php
// Start the session
session_start();

// Check if form was submitted using POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: index.html');
    exit();
}

// Get the form data
$fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

// Initialize error array
$errors = [];

// Validate fullname
if (empty($fullname)) {
    $errors[] = 'Full name is required';
} elseif (strlen($fullname) < 2) {
    $errors[] = 'Full name must be at least 2 characters';
}

// Validate email
if (empty($email)) {
    $errors[] = 'Email address is required';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please enter a valid email address';
}

// Validate subject
if (empty($subject)) {
    $errors[] = 'Please select a subject';
}

// Validate message
if (empty($message)) {
    $errors[] = 'Message cannot be empty';
} elseif (strlen($message) < 10) {
    $errors[] = 'Message must be at least 10 characters long';
}

// Get current timestamp
$submitted_at = date('Y-m-d H:i:s');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Status | Contact Form</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="wrapper">
        <div class="form-container response-container">
            
            <?php if (!empty($errors)): ?>
                <!-- Show errors if validation failed -->
                <div class="error-message">
                    <h3>⚠️ Please fix the following errors:</h3>
                    <ul style="text-align: left; margin-top: 15px;">
                        <?php foreach ($errors as $error): ?>
                            <li style="margin-bottom: 5px;"><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <a href="index.html" class="back-link">← Go Back to Form</a>
                
            <?php else: ?>
                <!-- Show success message -->
                <div class="success-message">
                    <h3>✅ Message Sent Successfully!</h3>
                    <p>Thank you for contacting us, <?php echo htmlspecialchars($fullname); ?>! We'll get back to you soon.</p>
                </div>
                
                <!-- Display submitted information -->
                <div class="message-details">
                    <h3>📋 Message Summary</h3>
                    
                    <div class="detail-item">
                        <span class="detail-label">Name:</span>
                        <?php echo htmlspecialchars($fullname); ?>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label">Email:</span>
                        <?php echo htmlspecialchars($email); ?>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label">Subject:</span>
                        <?php echo htmlspecialchars($subject); ?>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label">Sent:</span>
                        <?php echo $submitted_at; ?>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label">Message:</span><br>
                        <div style="margin-top: 10px; padding: 15px; background: white; border-radius: 5px; line-height: 1.6;">
                            <?php echo nl2br(htmlspecialchars($message)); ?>
                        </div>
                    </div>
                </div>
                
                <a href="index.html" class="back-link">← Send Another Message</a>
                
            <?php endif; ?>
            
        </div>
    </div>
</body>
</html>