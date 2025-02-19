<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#e8ebef">
    @php
        $header_logo = get_setting('header_logo');
    @endphp
    <tr>
        <td align="center" valign="top" class="container" style="padding:50px 10px;">
            <!-- Container -->
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="center">
                        <table width="650" border="0" cellspacing="0" cellpadding="0" class="mobile-shell">
                            <tr>
                                <td class="td" bgcolor="#ffffff"
                                    style="width:650px; min-width:650px; font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal;">
                                    <!-- Header -->
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0"
                                        bgcolor="#ffffff">
                                        <tr>
                                            <td class="p30-15-0" style="padding: 40px 30px 0px 30px;">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <th class="column"
                                                            style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal;">
                                                            <table width="100%" border="0" cellspacing="0"
                                                                cellpadding="0">
                                                                <tr>
                                                                    <td class="img m-center"
                                                                        style="font-size:0pt; line-height:0pt; text-align:left;">
                                                                        <img src="{{ uploaded_asset($header_logo) }}"
                                                                            alt="{{ env('APP_NAME') }}"
                                                                            class="mw-100 h-30px h-md-40px"
                                                                            height="40">
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </th>
                                                        <th class="column-empty" width="1"
                                                            style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal;">
                                                        </th>
                                                        <th class="column" width="120"
                                                            style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal;">
                                                            <table width="100%" border="0" cellspacing="0"
                                                                cellpadding="0">
                                                                <tr>
                                                                    <td class="text-header right"
                                                                        style="color:#000000; font-family:'Fira Mono', Arial,sans-serif; font-size:12px; line-height:16px; text-align:right;">
                                                                        <a href="{{ env('APP_URL') }}" target="_blank"
                                                                            class="link"
                                                                            style="color:#000001; text-decoration:none;">
                                                                            <span class="link"
                                                                                style="color:#000001; text-decoration:none;">{{ env('APP_NAME') }}</span>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </th>
                                                    </tr>
                                                </table>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td class="separator"
                                                            style="padding-top: 40px; border-bottom:4px solid #000000; font-size:0pt; line-height:0pt;">
                                                            &nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- END Header -->

                                    <!-- Intro -->
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0"
                                        bgcolor="#ffffff">
                                        <tr>
                                            <td class="p30-15" style="padding: 70px 30px 70px 30px;">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td class="h2 center pb10"
                                                            style="color:#000000; font-family:'Ubuntu', Arial,sans-serif; font-size:50px; line-height:60px; text-align:center; padding-bottom:10px;">
                                                            {{ translate('Dear') }} {{ $array['name'] ?? '' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="h5 center pb30"
                                                            style="font-family:'Ubuntu', Arial,sans-serif; font-size:20px; line-height:26px; text-align:center; padding-bottom:30px;">
                                                            {{ translate('Thank you for registering on') }}
                                                            {{ env('APP_NAME') }}.
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="h5 center pb30"
                                                            style="font-family:'Ubuntu', Arial,sans-serif; font-size:18px; line-height:26px; text-align:center; padding-bottom:20px;">
                                                            {{ translate('Your username is the following:') }}<br>
                                                            <strong>{{ $array['email'] }}</strong>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="h5 center pb30"
                                                            style="font-family:'Ubuntu', Arial,sans-serif; font-size:18px; line-height:26px; text-align:center; padding-bottom:30px;">
                                                            {{ translate('Please click on the link below to activate your account:') }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="h5 center blue pb30"
                                                            style="font-family:'Ubuntu', Arial,sans-serif; font-size:20px; line-height:26px; text-align:center; color:#2e57ae; padding-bottom:30px;">
                                                            <a href="{{ $array['link'] ?? '' }}"
                                                                style="background: #007bff; padding: 0.9rem 2rem; font-size: 0.875rem; color:#fff; border-radius: .2rem;"
                                                                target="_blank">{{ translate('Activate my account') }}</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="h5 center pb30"
                                                            style="font-family:'Ubuntu', Arial,sans-serif; font-size:18px; line-height:26px; text-align:center; padding-bottom:20px;">
                                                            {{ translate('Once you have created your password, you will be able to access your online user profile and track the status of your ' . $array['email'] . ' at any time.') }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="h5 center pb30"
                                                            style="font-family:'Ubuntu', Arial,sans-serif; font-size:16px; line-height:26px; text-align:center; padding-bottom:30px;">
                                                            {{ translate("If the activation link above doesn't work, please paste the following link in your web browser:") }}<br>
                                                            <a href="{{ $array['link'] ?? '' }}"
                                                                target="_blank">{{ $array['link'] ?? '' }}</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="h5 center pb30"
                                                            style="font-family:'Ubuntu', Arial, sans-serif; font-size:16px; line-height:26px; text-align:center; padding-bottom:30px;">
                                                            {{ translate('Should you need further information, please do not hesitate to contact us via our Email.') }}
                                                            <a href="mailto:info.support@e-tinda.com"
                                                                style="color:inherit; text-decoration:none;"
                                                                target="_blank">
                                                                info.support@e-tinda.com
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="h5 center pb30"
                                                            style="font-family:'Ubuntu', Arial,sans-serif; font-size:16px; line-height:26px; text-align:center; padding-bottom:30px;">
                                                            {{ translate('Kind Regards,') }}<br>{{ translate('eTinda Support Team') }}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- END Intro -->
                                </td>
                            </tr>
                            <tr>
                                <td class="text-footer"
                                    style="padding-top: 30px; color:#1f2125; font-family:'Fira Mono', Arial,sans-serif; font-size:12px; line-height:22px; text-align:center;">
                                    {{ env('APP_NAME') }}  {{ translate('Support Team') }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <!-- END Container -->
        </td>
    </tr>
</table>
