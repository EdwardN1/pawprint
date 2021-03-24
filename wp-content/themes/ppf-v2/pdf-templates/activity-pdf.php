<html>

    <head>
        <style>

            @page{
                margin: 10px;
            }

            *{
                font-family: 'Helvetica';
            }

            .activity_type_Other{ background: #9933ff !important; color: #FFF; }
            .activity_type_Craft{ background: #ff9d33 !important; color: #FFF; }
            .activity_type_Food{ background: #00aa4f !important; color: #FFF; }
            .activity_type_Games{ background: #2096fb !important; color: #FFF; }

            .header{
                width: 100%;
                display: block;
                clear: both;
                padding: 30px;
                font-size: 20px;
                margin: 0 0 10px;
                font-family: 'Helvetica';
            }

            table{
                width: 100%;
                display: block;
                clear: both;
            }

            p{
                color: #000;
                font-size: 14px;
                margin: 0 0 10px;
                font-family: 'Helvetica';
            }

            h2{
                margin: 0 0 20px;
                display: block;
                clear: both;
                font-family: 'Helvetica';
                font-size: 20px;
            }

            h3{
                margin: 0 0 20px;
                display: block;
                clear: both;
                font-family: 'Helvetica';
                font-size: 16px;
            }

            dd{
                width: 100%;
                display: block;
            }
            
        </style>
    </head>
    <body>

        <div class="header" style="background: {{COLOUR}};">
            {{ TITLE }}
            {{ ICON_IMG }}
        </div>

        <table cellspacing="0" cellpadding="0">

            <tbody>

                <tr>

                    <td width="90%" valign="top">

                        <table cellpadding="10" cellspacing="0">
                            <tbody>
                            <tr>
                                <td valign="top">
                                    {{ CONTENT }}
                                    {{ AGES }}
                                </td>
                            </tr>
                            </tbody>
                        </table>

                    </td>
                    <td width="10%" valign="top">

                        <table cellpadding="10">
                            <tbody>
                            <tr>
                                <td valign="top">
                                    <h2 style="color: #33b4a7;">Activity details</h2><br>
                                    <table cellpadding="10" cellspacing="0">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <h3>This activity counts towards...</h3><br/>
                                                {{ BADGES }}
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <table cellpadding="10">
                            <tbody>
                                <tr>
                                    <td valign="top">
                                        <img src="{{ GENERAL_INFO }}" alt="">
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <img src="{{ SIDEBAR_AGES }}" alt="">
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <img src="{{ SIDEBAR_SEASONS }}" alt="">
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