<?php
session_start(); // Zorg ervoor dat session_start bovenaan staat

if (isset($_POST['submit'])) {

    if (isset($_POST['email']) && isset($_POST['password'])) {
        if (!empty($_POST['email']) && !empty($_POST['password'])) {

            $emailForm = $_POST['email'];
            $passwordForm = $_POST['password'];

            include 'database.php';

            // Controleer eerst of het een admin is
            $stmt = $pdo->prepare("SELECT * FROM Admins WHERE email = ?");
            $stmt->execute([$emailForm]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            // Als admin is gevonden
            if ($admin && password_verify($passwordForm, $admin['password'])) {
                $_SESSION['admin_id'] = $admin['admin_id'];
                $_SESSION['name'] = $admin['name'];
                $_SESSION['email'] = $admin['email'];
                header("Location: admin-dashboard.php"); // Redirect naar admin-dashboard
                exit;
            } 

            // Controleer of het een customer is als geen admin
            $stmt = $pdo->prepare("SELECT * FROM Customers WHERE email = ?");
            $stmt->execute([$emailForm]);
            $customer = $stmt->fetch(PDO::FETCH_ASSOC);

            // Als klant is gevonden
            if ($customer && password_verify($passwordForm, $customer['password'])) {
                $_SESSION['customer_id'] = $customer['customer_id'];
                $_SESSION['name'] = $customer['name'];
                $_SESSION['email'] = $customer['email'];
                header("Location: customer-dashboard.php"); // Redirect naar customer-dashboard
                exit;
            }

            echo "Fout wachtwoord of gebruiker niet gevonden.";
        }
    }
}
?>
