
<?php
session_start();
if (!isset($_SESSION['google_auth']) && !isset($_SESSION['github_auth']) && !isset($_SESSION['email_auth'])) {
   header('location: ./index.php');
   exit();
   
}


include './Database/db.php';

// Check which session variable is set and get the user ID
$id = isset($_SESSION['google_auth']) ? $_SESSION['google_auth'] : (isset($_SESSION['github_auth']) ? $_SESSION['github_auth'] : $_SESSION['email_auth']);

// Use prepared statements to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM users WHERE SN = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$details = $result->fetch_object();

$profileImage = htmlspecialchars($details->Avatar, ENT_QUOTES, 'UTF-8'); // Sanitize output
$name = htmlspecialchars($details->First_Name, ENT_QUOTES, 'UTF-8'); // Sanitize output
$email = htmlspecialchars($details->Email, ENT_QUOTES, 'UTF-8'); // Sanitize output


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Book a Mental Health Appointment</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f5f5f5;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .booking-form {
      background-color: #ffffff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 500px;
    }
    .booking-form h2 {
      margin-bottom: 20px;
      color: #333;
    }
    .booking-form input, .booking-form select, .booking-form textarea, .booking-form button {
      width: 100%;
      padding: 12px;
      margin-top: 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 16px;
    }
    .booking-form button {
      background-color: #4CAF50;
      color: white;
      cursor: pointer;
      margin-top: 20px;
      border: none;
    }
    .booking-form button:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body >

  <form class="booking-form" action="appointment.php" method="POST">
    <h2>Book a Mental Health Appointment</h2>

    <input type="text" name="fullname" value="<?=$name?>" placeholder="Full Name" required>
    
    <input type="email" name="email" value="<?=$email?>" placeholder="Email Address" required>
    
    <input type="tel" name="phone" placeholder="Phone Number" pattern="^\+254[0-9]{9}$" maxlength="13" value="+254" required>

    <input type="text" name="address" placeholder="Address / Location" required>

    <select name="service" required>
      <option value="">Select Service</option>
      <option value="counseling">Counseling</option>
      <option value="therapy">Therapy Session</option>
      <option value="psychiatrist">Psychiatrist Consultation</option>
    </select>

    <input type="date" name="date" required>
    
    <input type="time" name="time" required>

    <textarea name="notes" rows="4" placeholder="Additional Notes (optional)"></textarea>

    <button type="submit">Book Appointment</button>
  </form>

</body>
</html>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

require './vendor/autoload.php';
require_once './Database/db.php';

// Load environment variables
$dotenv = Dotenv::createImmutable('./');
$dotenv->load();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $service = $_POST['service'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $notes = $_POST['notes'];

    // Send appointment confirmation email
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['GMAIL_USERNAME'];
        $mail->Password = $_ENV['GMAIL_APP_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom($_ENV['GMAIL_USERNAME'], 'Inner Balance');
        $mail->addAddress($email, $fullname);
        $mail->addReplyTo($_ENV['GMAIL_USERNAME'], 'Inner Balance');

        // Email Content
        $mail->isHTML(true);
        $mail->Subject = 'Appointment Confirmation - Inner Balance';
        $mail->Body = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px; }
                .container { background-color: #ffffff; padding: 20px; border-radius: 8px; max-width: 600px; margin: auto; }
                .header { font-size: 24px; font-weight: bold; text-align: center; color: #333333; }
                .details { margin-top: 20px; }
                .details p { margin: 10px 0; }
                .footer { margin-top: 30px; text-align: center; font-size: 14px; color: #777777; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>Appointment Confirmed</div>
                <p>Hello <strong>$fullname</strong>,</p>
                <p>Thank you for booking a mental health appointment with <strong>Inner Balance</strong>. Here are your appointment details:</p>
                <div class='details'>
                    <p><strong>Service:</strong> $service</p>
                    <p><strong>Date:</strong> $date</p>
                    <p><strong>Time:</strong> $time</p>
                    <p><strong>Phone:</strong> $phone</p>
                    <p><strong>Address:</strong> $address</p>
                    " . (!empty($notes) ? "<p><strong>Notes:</strong> $notes</p>" : "") . "
                </div>
                <p>We look forward to seeing you!</p>
                <div class='footer'>
                    <p><strong>Inner Balance</strong></p>
                    <p><a href='#'>www.innerbalance.org</a> | info.innerbalance.org</p>
                </div>
            </div>
        </body>
        </html>
        ";

        $mail->AltBody = "Hello $fullname,\n\nYour appointment for $service on $date at $time has been confirmed.\n\n- Inner Balance";

        $mail->send();

                  // Send notification to admin
          $adminMail = new PHPMailer(true);
          try {
              $adminMail->isSMTP();
              $adminMail->Host = 'smtp.gmail.com';
              $adminMail->SMTPAuth = true;
              $adminMail->Username = $_ENV['GMAIL_USERNAME'];
              $adminMail->Password = $_ENV['GMAIL_APP_PASSWORD'];
              $adminMail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
              $adminMail->Port = 587;

              $adminMail->setFrom($_ENV['GMAIL_USERNAME'], 'Inner Balance');
              $adminMail->addAddress('innerbalance254@gmail.com', 'Admin');
              $adminMail->addReplyTo($_ENV['GMAIL_USERNAME'], 'Inner Balance');

              $adminMail->isHTML(true);
              $adminMail->Subject = 'New Appointment Booked';
              $adminMail->Body = "
              <html>
              <body>
                  <h2>New Appointment Notification</h2>
                  <p><strong>Client:</strong> $fullname</p>
                  <p><strong>Email:</strong> $email</p>
                  <p><strong>Phone:</strong> $phone</p>
                  <p><strong>Address:</strong> $address</p>
                  <p><strong>Service:</strong> $service</p>
                  <p><strong>Date:</strong> $date</p>
                  <p><strong>Time:</strong> $time</p>
                  " . (!empty($notes) ? "<p><strong>Notes:</strong> $notes</p>" : "") . "
              </body>
              </html>
              ";
              $adminMail->AltBody = "New Appointment:\nClient: $fullname\nEmail: $email\nPhone: $phone\nService: $service\nDate: $date\nTime: $time";

              $adminMail->send();

          } catch (Exception $e) {
              error_log("Admin email could not be sent. Error: {$adminMail->ErrorInfo}");
          }

        // exit();

            echo '
            <script>
                alert("Your appointment has been successfully booked. A confirmation email has been sent to you.");
                window.location.href = "./index.php";
            </script>
        ';
    
      
      
      

    } catch (Exception $e) {
        echo "Email could not be sent. Error: {$mail->ErrorInfo}";
        exit();
    }
}
?>


    