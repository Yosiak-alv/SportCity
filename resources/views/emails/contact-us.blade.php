<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Successfully send your message</title>	
</head>
<body>
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tbody>
			<tr>
				<td width="640">
					<table border="0" cellpadding="0" cellspacing="0" width="640">
						<tbody>
							<tr>
								<td width="640">
									<div class="content-block">
										<h1>Hi {{ $data['name'] }}, </h1>
										
										<p>Successfully submit your inquery. A supporting persion contact with within 24 hours.</p>
											
										<p><strong>Your submitted information below:</strong></p>
										<p><strong>E-mail:</strong> {{ $data['email'] }}</p>
										<p><strong>Your Message:</strong><br> {{ $data['message'] }}</p>
									</div>
								</td>
							</tr>
							<tr>
								<td height="40" width="640"> </td>
							</tr>
							<tr>
								<td>
									<p align="center">Thank you, <em>SportCity.com</em></p>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
</body>
</html>