<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Suscription Invoice {{$suscription?->id}}</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    #invoice {
      max-width: 800px;
      margin: 20px auto;
      padding: 20px;
      border: 1px solid #ccc;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    #invoice header {
      text-align: center;
      margin-bottom: 20px;
    }

    #client-info, #gym-info, #purchase-info, #payment-info {
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    th, td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }

    th {
      background-color: #f2f2f2;
    }

    #payment-info {
      text-align: right;
    }
  </style>
</head>
<body>

  <div id="invoice">
    <header>
      <h1>Subcription Invoice #{{$suscription?->id}}</h1>
    </header>

    <section id="client-info">
      <h2>Client Information</h2>
      {{$suscription?->client?->name}}, {{$suscription?->client?->lastname}}<br>
      {{$suscription?->client?->dui}}<br> 
      {{$suscription?->client?->email}}<br> 
      {{$suscription?->client?->address}}<br> 
      Phone: {{$suscription?->client?->phone}}<br>
    </section>

    <section id="gym-info">
      <h2>Gym Information</h2>
      {{$suscription?->client?->gym?->name ?? 'Current Gym has been Deleted'}}<br> 
      {{$suscription?->client?->gym?->email}}<br>
      {{$suscription?->client?->gym?->address}}<br>
      {{$suscription?->client?->gym?->department->name}}<br>
    </section>

    <section id="purchase-info">
      <h2>Purchase Information</h2>
      <table>
        <thead>
          <tr>
            <th>Item</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{$suscription?->plan?->name}}</td>
            <td>1</td>
            <td>${{$suscription?->plan?->price}}</td>
            <td>${{$suscription?->plan?->price}}</td>
          </tr>
        </tbody>
      </table>
    </section>

    <section id="payment-info">
      <h2>Payment Information</h2>
      <p><strong>Total Amount:</strong> ${{$suscription?->plan?->price}}</p>
      <p><strong>Payment Method:</strong> USD -Dollars</p>
      <p><strong>Transaction:</strong> Cash</p>
      <p><strong>Date:</strong> {{$suscription?->created_at}}</p>
    </section>
  </div>

</body>
</html>

