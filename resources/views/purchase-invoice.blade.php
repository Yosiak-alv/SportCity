<!doctype html>
<html>
<head>
    <meta charset="utf-8">
	  <title>Purchase Invoice {{$purchase?->id}}</title>
    
    <style>
    body {
      color: #f00;
      font-family: Helvetica;
    }
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }
    
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }
    
    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }
    
    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }
    
    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }
    
    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }
    
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    
    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }
    
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    
    .invoice-box table tr.total td:nth-child(2) {
      border-top: 2px solid #eee;
      font-weight: bold;
    }
    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
          width: 100%;
          display: block;
          text-align: center;
        }
        
        .invoice-box table tr.information table td {
          width: 100%;
          display: block;
          text-align: center;
        }
    }
    
    /** RTL **/
    .rtl {
      direction: rtl;
      font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }
    
    .rtl table {
      text-align: right;
    }
    
    .rtl table tr td:nth-child(2) {
      text-align: left;
    }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="{{ public_path("storage/img/homepage/SportCity-Logo.JPG") }}" style="width:100%; max-width:300px;" alt="SportCity">
                            </td>
                            
                            <td>
                                <strong><small>PURCHASE</small></strong>  #{{$purchase?->id}}<br />
            					          <small>{{$purchase?->created_at}}</small>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <strong>GYM INFORMATION</strong>.<br>
                                {{$client?->gym->name}}<br> 
                                {{$client?->gym->email}}<br>
                                {{$client?->gym->address}}<br>
                                {{$client?->gym->department->name}}<br>
                            </td>
                            
                            <td>
                                <strong>BILLING INFORMATION</strong><br>
                                {{$client?->name}}, {{$client?->lastname}}<br>
                                {{$client?->dui}}<br> 
                                {{$client?->email}}<br> 
                                {{$client?->address}}<br> 
                                Phone: {{$client?->phone}}<br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="heading">
                <td>
                    <strong>PAYMENT METHOD</strong>
                </td>
            </tr>
            
            <tr class="details">
                <td>
                    Cash
                    USD - US Dollar
                  </td>
            </tr>
            
            <tr class="heading">
                <td>
                  Item
                </td>
                
                <td>
                  Price
                </td>
            </tr>
            
            @foreach($purchase?->purchaseItems as $purchaseItem)
                <tr class="item">
                    <td>
                        {{$purchaseItem?->product->name}}
                    </td>
                    
                    <td>
                        ${{$purchaseItem?->item_total}}
                    </td>
                </tr>
            @endforeach
            
            
            <tr class="total">
                <td>
                    SubTotal: ${{$purchase?->sub_total}} USD <br>
                </td>
                <td>
                    Taxes: ${{$purchase?->taxes}} USD <br>
                </td>
                <td>
                  Total: ${{$purchase?->total}} USD <br>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
