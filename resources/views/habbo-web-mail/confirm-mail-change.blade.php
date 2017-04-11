<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse:collapse">
    <tbody>
    <tr>
        <td
            style="color:#000000;font-family:'Ubuntu','Trebuchet MS','Lucida Grande','Lucida Sans Unicode','Lucida Sans',Tahoma,sans-serif;border-collapse:collapse;padding:0 10px 0 10px">
            <table align="center" border="0" cellpadding="0" cellspacing="0"
                   style="border-collapse:collapse;width:100%">
                <tbody>
                <tr>
                    <td align="left"
                        style="color:#000000;font-family:'Ubuntu','Trebuchet MS','Lucida Grande','Lucida Sans Unicode','Lucida Sans',Tahoma,sans-serif;border-collapse:collapse;padding:10px 0 0 0">
                        <img src="http://imgur.com/HAs98Uo.png" alt="Habbo" height="40" width="110" class="CToWUd">
                    </td>
                </tr>
                </tbody>
            </table>
            <table align="center" border="0" cellpadding="0" cellspacing="0"
                   style="border-collapse:collapse;width:100%">
                <tbody>
                <tr>
                    <td align="left"
                        style="color:#000000;font-family:'Ubuntu','Trebuchet MS','Lucida Grande','Lucida Sans Unicode','Lucida Sans',Tahoma,sans-serif;border-collapse:collapse;padding:32px 0 24px 0">
                        <h1 style="font-family:'Ubuntu Condensed','Trebuchet MS','Lucida Grande','Lucida Sans Unicode','Lucida Sans',Tahoma,sans-serif;font-size:24px;font-weight:normal;line-height:1;margin:0;padding:0 0 24px 0">
                            Hey there {{$name}}!</h1>
                        <p style="color:#000000;font-family:'Ubuntu','Trebuchet MS','Lucida Grande','Lucida Sans Unicode','Lucida Sans',Tahoma,sans-serif;font-size:16px;line-height:1.4;padding:0;margin:0 0 16px 0">
                            A yellow ducky told us that you requested to change your email address of the {{$chocolatey->hotelName}} account
                            to the email address: {{$email}}
                        </p>
                        <p style="color:#000000;font-family:'Ubuntu','Trebuchet MS','Lucida Grande','Lucida Sans Unicode','Lucida Sans',Tahoma,sans-serif;font-size:16px;line-height:1.4;margin:16px 0 16px 0;padding:0">
                            The link below will expire in 48 hours, so be quick!</p>
                        <p style="color:#000000;font-family:'Ubuntu','Trebuchet MS','Lucida Grande','Lucida Sans Unicode','Lucida Sans',Tahoma,sans-serif;font-size:16px;line-height:1.4;margin:16px 0 16px 0;padding:0">
                            <a href="{{$chocolatey->hotelUrl}}/{{$url}}"
                               style="text-decoration:none;color:#ffffff;background-color:#00813e;border-radius:5px;display:inline-block;font-family:'Ubuntu Condensed','Trebuchet MS','Lucida Grande','Lucida Sans Unicode','Lucida Sans',Tahoma,sans-serif;font-size:18px;padding:8px 24px"
                               target="_blank">Click here to securely change your email address</a></p>
                        <p style="color:#000000;font-family:'Ubuntu','Trebuchet MS','Lucida Grande','Lucida Sans Unicode','Lucida Sans',Tahoma,sans-serif;font-size:16px;line-height:1.4;margin:16px 0 16px 0;padding:0">
                            Didn’t request this change? If this was a mistake, just ignore this email and your current
                            email address will remain valid.</p>
                        <p style="color:#000000;font-family:'Ubuntu','Trebuchet MS','Lucida Grande','Lucida Sans Unicode','Lucida Sans',Tahoma,sans-serif;font-size:16px;line-height:1.4;padding:0;margin:16px 0 0 0">
                            – {{$chocolatey->hotelName}} Staff</p>
                    </td>
                </tr>
                </tbody>
            </table>
            <table align="center" border="0" cellpadding="0" cellspacing="0"
                   style="border-collapse:collapse;width:100%">
                <tbody>
                <tr>
                    <td align="center"
                        style="font-family:'Ubuntu','Trebuchet MS','Lucida Grande','Lucida Sans Unicode','Lucida Sans',Tahoma,sans-serif;border-collapse:collapse;color:#818a91;border-top:1px solid #aaaaaa;font-size:10px;line-height:1.4;padding:10px">
                        © 2017 {{$chocolatey->hotelName}} by Chocolatey
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
