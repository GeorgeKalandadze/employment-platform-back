<div style="background-color: #0D0B14; height: 100%; width: 100%; font-family: Arial;">
    <div style="padding: 40px">
        <table style="align-items: center; text-align: center; width: 100%">
            <tr>
                <td style="align-items: center; text-align: center">
                    <img src="https://i.postimg.cc/GhR6x8N5/quote-icon.png" title="Quote Icon" width="22px" height="22px"
                        alt="not found" />
                    <p style="color: #DDCCAA">EMPLOYMENT PLATFORM / WEEKLY REPORT FOR YOU!</p>
                </td>
            </tr>
        </table>
        <br />
        <table style="color: white">
            <tr>
                <td style="color: white">Hello {{ $reportData['creator'] }}!</td>
            </tr>
            <br />
                <tr >
                    <td style="color: white">
                        New vacancies at this week: {{$reportData['new_vacancies_count']}}
                    </td>
                </tr>
                <tr >
                   <td style="color: white"> All vacancies views: {{$reportData['views_count']}}</td>
                </tr>
               @if (isset($reportData['new_followers']))
                  <tr style="color: white">
                    <td  style="color: white">New folowers: {{$reportData['new_followers']}}</td>
                  </tr>
               @endif
                

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
