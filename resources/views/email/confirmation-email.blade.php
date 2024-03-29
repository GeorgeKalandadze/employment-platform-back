<div style="background-color: #0D0B14; height: 100%; width: 100%">
    <div style="padding: 40px">
        <table style="align-items: center; text-align: center; width: 100%">
            <tr>
                <td style="align-items: center; text-align: center">
                    <img src="https://i.postimg.cc/GhR6x8N5/quote-icon.png" title="Quote Icon" width="22px" height="22px"
                        alt="not found" />
                    <p style="color: #DDCCAA">EMPLOYMENT PLATFORM</p>
                </td>
            </tr>
        </table>
        <br />
        <br />
        <table>
            <tr>
                <td style="color: white">Hollo {{ $user->username }}!</td>
            </tr>
            <br />
            <tr>
                <td style="color: white; margin-top: 4px; margin-bottom: 4px">Thanks for joining Movie quotes! We
                    really
                    appreciate it. Please click the button
                    below to verify your
                    email:
                </td>
            </tr>
            <br />
            <tr>
                <td>
                    <a href="{{ env('FRONT_BASE_URL') . '/email-verified?userId='. $user->id .'&email=' . $email }}"
                        style="text-decoration: none; padding: 10px; border-radius: 6px;  color: white; background-color: #E31221;">
                        Verify email
                    </a>
            </tr>
            <br />
            <tr>
                <td>
                    <p style="color: white">
                        If clicking doesn't work, you can try
                        copying
                        and pasting it to your browser:
                    </p>
                </td>
            </tr>
            <br />
            <tr>
                <td>
                    <a style="color: #DDCCAA">{{ env('FRONT_BASE_URL') . '/email-verified?userId='. $user->id .'&email=' . $email }}</a>
                </td>
            </tr>
            <br />
            <tr>
                <td>
                    <p style="color: white">
                        If you have any problems, please contact
                        us:
                        support@emploWeb.ge
                    </p>
                </td>
            </tr>
        </table>
    </div>
</div>
