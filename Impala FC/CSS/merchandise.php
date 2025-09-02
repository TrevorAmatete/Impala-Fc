<?php
// Handle form submission
$discount = 0;
$total = 0;
$discountedTotal = 0;
$isMember = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $membership = $_POST['membership'];
    $items = $_POST['items'];
    $total = 0;

    foreach ($items as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    if (!empty($membership)) {
        $isMember = true;
        $discount = 0.15;
        $discountedTotal = $total - ($total * $discount);
    } else {
        $discountedTotal = $total;
    }

    // Trigger MPESA payment
    $phone = $_POST['phone'];
    initiateMpesa($discountedTotal, $phone);
}

function initiateMpesa($amount, $phone)
{
    // Replace with your Daraja credentials
    $consumerKey = 'YOUR_CONSUMER_KEY';
    $consumerSecret = 'YOUR_CONSUMER_SECRET';
    $BusinessShortCode = '174379';
    $Passkey = 'YOUR_PASSKEY';
    $PartyA = $phone;
    $AccountReference = "ImpalaFC";
    $TransactionDesc = "Merchandise Purchase";
    $TransactionType = "CustomerPayBillOnline";
    $CallBackURL = "https://yourdomain.com/callback.php";

    $lipa_time = date('YmdHis');
    $password = base64_encode($BusinessShortCode . $Passkey . $lipa_time);

    // Get access token
    $credentials = base64_encode($consumerKey . ':' . $consumerSecret);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Basic ' . $credentials]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = json_decode(curl_exec($ch));
    curl_close($ch);

    $access_token = $response->access_token;

    // Initiate payment
    $postData = [
        'BusinessShortCode' => $BusinessShortCode,
        'Password' => $password,
        'Timestamp' => $lipa_time,
        'TransactionType' => $TransactionType,
        'Amount' => $amount,
        'PartyA' => $PartyA,
        'PartyB' => $BusinessShortCode,
        'PhoneNumber' => $PartyA,
        'CallBackURL' => $CallBackURL,
        'AccountReference' => $AccountReference,
        'TransactionDesc' => $TransactionDesc
    ];

    $ch = curl_init('https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $access_token
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    $result = curl_exec($ch);
    curl_close($ch);

    echo "<p>Payment request sent to {$phone}. Confirm on your phone.</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Impala FC Merchandise</title>
  <style>
    body { font-family: Arial; background: #f8f9fa; padding: 20px; }
    .product { background: #fff; padding: 10px 20px; border-radius: 10px; margin-bottom: 10px; box-shadow: 0 0 8px rgba(0,0,0,0.1);}
    input[type="number"] { width: 60px; }
    .total { font-size: 1.2em; font-weight: bold; margin-top: 20px; }
    .submit-btn { background: #007bff; color: white; padding: 10px 20px; border: none; cursor: pointer; border-radius: 5px; }
  </style>
</head>
<body>
  <h1>Impala FC Merchandise Store</h1>
  <form method="post">
    <?php
      $products = [
        ["name" => "Hoodie", "price" => 1500],
        ["name" => "Polo Shirt", "price" => 1200],
        ["name" => "Mug", "price" => 500],
        ["name" => "Keychain", "price" => 300],
        ["name" => "Fan Jersey", "price" => 1800]
      ];
      foreach ($products as $index => $product) {
        echo "<div class='product'>
                <h3>{$product['name']} (KES {$product['price']})</h3>
                <label>Quantity: <input type='number' name='items[$index][quantity]' value='0' min='0'></label>
                <input type='hidden' name='items[$index][price]' value='{$product['price']}'>
              </div>";
      }
    ?>
    <div class="product">
      <label>Membership Card No. (Optional for 15% discount):</label><br>
      <input type="text" name="membership" placeholder="Enter if member">
    </div>

    <div class="product">
      <label>Phone Number (M-PESA):</label><br>
      <input type="text" name="phone" required placeholder="07XXXXXXXX">
    </div>

    <button type="submit" class="submit-btn">Proceed to Checkout</button>
  </form>

  <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
    <div class="total">
      <?php
        echo "<p>Total: KES " . number_format($total, 2) . "</p>";
        if ($isMember) {
            echo "<p>15% Member Discount Applied!</p>";
        }
        echo "<p>Final Amount: <strong>KES " . number_format($discountedTotal, 2) . "</strong></p>";
      ?>
    </div>
  <?php endif; ?>
</body>
</html>