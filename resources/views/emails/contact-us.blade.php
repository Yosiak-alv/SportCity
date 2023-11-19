<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FitLife Gym Newsletter</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 600px;
      margin: 0 auto;
      background-color: #ffffff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    header {
      text-align: center;
    }

    header h1 {
      color: #333333;
    }

    .content {
      margin-top: 20px;
    }

    p {
      color: #555555;
      line-height: 1.6;
    }

    .cta-button {
      display: inline-block;
      padding: 10px 20px;
      background-color: #4CAF50;
      color: #ffffff;
      text-decoration: none;
      border-radius: 3px;
    }

    footer {
      margin-top: 20px;
      text-align: center;
      color: #888888;
    }
  </style>
</head>
<body>
  <div class="container">
    <header>
      <h1>SportCity</h1>
    </header>

    <div class="content">
      <p>Hi,{{ $data['name'] }}</p>
      <p>{{ $data['email'] }}</p>
      <p>Get ready for an amazing fitness journey with SportCity! Our state-of-the-art facilities and expert trainers are here to help you achieve your fitness goals.</p>
      <p>Here's what we offer:</p>
      <ul>
        <li>Modern workout equipment</li>
        <li>Group fitness classes</li>
        <li>Personalized training programs</li>
        <li>And much more!</li>
      </ul>
      <p>Ready to take the first step? Join us today and start your fitness journey!</p>
    </div>

    <footer>
      <p>Stay fit with SportCity</p>
    </footer>
  </div>
</body>
</html>